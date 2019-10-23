#!/usr/bin/env php
<?php

// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

\set_time_limit(0);

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

require __DIR__.'/../vendor/autoload.php';

// Vars
$baseLd2Path = $argv[1];
$clientExtractFilename = 'client-extract.json';
$fileContent = \file_get_contents(\sprintf('%s/%s', $baseLd2Path, $clientExtractFilename));
$extractConf = \json_decode($fileContent, true);

// Require ld2 autoload
$loader = require \sprintf('%s/%s', $baseLd2Path, $extractConf['autoload_path']);
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

class UniversalAnnotationReader extends AnnotationReader
{
    /**
     * Get type of property from property declaration.
     *
     * @param \ReflectionProperty $property
     *
     * @return null|string
     */
    public function getPropertyType(\ReflectionProperty $property): ?string
    {
        $doc = $property->getDocComment();
        \preg_match_all('#@var (.*?)\n#s', $doc, $annotations);

        return $annotations[1][0];
    }

    /**
     * Get groups of property from property declaration.
     *
     * @param array $property
     *
     * @return null|array
     */
    public function getPropertyGroups(array $annotations): ?array
    {
        $groups = [];

        foreach ($annotations as $annotation) {
            if ($annotation instanceof \Symfony\Component\Serializer\Annotation\Groups) {
                $groups = $annotation;
            }
        }

        if (empty($groups)) {
            return null;
        }

        return $groups->getGroups();
    }
}

if (!isset($argv[1])) {
    echo 'Error : missing filename parameter'.PHP_EOL;
    exit(1);
}

if (!\file_exists($argv[1])) {
    echo "Error : File \"{$argv[1]}\" not found".PHP_EOL;
    exit(1);
}

$annotationReader = new UniversalAnnotationReader();

main($baseLd2Path, $extractConf);

function main(string $baseLd2Path, array $extractConf): void
{
    $fileSystem = new Filesystem();
    $entityDirPath = 'var/Entity';

    try {
        $fileSystem->remove($entityDirPath);
    } catch (IOExceptionInterface $exception) {
        echo 'An error occurred while creating your directory at '.$exception->getPath();
    }

    try {
        $fileSystem->mkdir($entityDirPath);
    } catch (IOExceptionInterface $exception) {
        echo 'An error occurred while creating your directory at '.$exception->getPath();
    }

    foreach ($extractConf['entity_directories'] as $entityPath) {
        $finder = new \Symfony\Component\Finder\Finder();
        $files = $finder->files()->name('*.php')->in(\sprintf('%s/%s', $baseLd2Path, $entityPath));

        foreach ($files as $file) {
            echo "Parse file ${file}\n";
            if (!\strpos($file->getRealPath(), 'Interface.php')) {
                list($entityName, $entityContent) = processEntity(\file_get_contents($file->getRealPath()));

                // Save Entity in file
                $fileSystem->appendToFile(\sprintf('%s/%s.php', $entityDirPath, $entityName), $entityContent);
            }
        }
    }

    // CS-Fixer
    $csFixer = new \Symfony\Component\Process\Process(
        [
            'php',
            'vendor/bin/php-cs-fixer',
            'fix',
            '--no-ansi',
            $entityDirPath,
        ]
    );
    $csFixer->run();

    // executes after the command finishes
    if (!$csFixer->isSuccessful()) {
        echo 'Error with CS-Fixer command';
    }

    echo $csFixer->getOutput();
}

function processEntity(string $entityContent): array
{
    global $annotationReader;

    $content = <<<EOF
<?php
        
declare(strict_types=1);
        
namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;


EOF;

    \preg_match('/^namespace (.+);/m', $entityContent, $matches);
    $namespace = $matches[1];
    \preg_match('/^class ([a-zA-Z0-9\\_]+)/m', $entityContent, $matches);
    $classname = $matches[1];

    $reflectedClass = new \ReflectionClass($namespace.'\\'.$matches[1]);

    $content .= generateClassDoc($reflectedClass->getProperties());

    $content .= <<<EOF
class ${classname} extends ProxyObject
{

EOF;

    $content .= generateProperties($reflectedClass->getProperties());

    $content .= <<<EOF

}
EOF;

    return [$classname, $content];
}

function generateClassDoc(array $reflectionProperties): string
{
    global $annotationReader;

    $classDoc = '/**'.PHP_EOL;

    foreach ($reflectionProperties as $reflectionProperty) {
        // Annotations
        $annotation = $annotationReader->getPropertyType($reflectionProperty);

        $propertyName = $reflectionProperty->getName();

        $isNullable = '?' === \substr($annotation, 0, 1);
        $realType = $isNullable ? \substr($annotation, 1) : $annotation;

        // Type
        if ($isNullable) {
            $stringType = $realType.'|null';
        } else {
            $stringType = $realType;
        }

        // Getter
        $getterPrefix = 'get';
        if ('bool' === $realType || 'boolean' === $realType) {
            $getterPrefix = 'is';
        }
        $stringGetter = $getterPrefix.\ucfirst($propertyName).'()';

        // Setter
        $stringSetter = 'set'.\ucfirst($propertyName).'('.$stringType.' $'.$propertyName.')';
        $classDoc .= \sprintf(' * @method %s %s', $stringType, $stringGetter).PHP_EOL;
        $classDoc .= \sprintf(' * @method void %s', $stringSetter).PHP_EOL;
    }
    $classDoc .= ' */'.PHP_EOL;

    return $classDoc;
}

function generateProperties(array $reflectionProperties): string
{
    $properties = '';

    // Annotation
    foreach ($reflectionProperties as $reflectionProperty) {
        $properties .= generateAnnotationForProperties($reflectionProperty);

        $propertyName = $reflectionProperty->getName();
        $properties .= <<<EOF
    public $${propertyName};


EOF;
    }

    return $properties;
}

function generateAnnotationForProperties(ReflectionProperty $reflectionProperty): ?string
{
    global $annotationReader;

    $annotationsString = <<<EOF
    /**
EOF;
    $annotations = $annotationReader->getPropertyAnnotations($reflectionProperty);

    if ($type = $annotationReader->getPropertyType($reflectionProperty)) {
        $annotationsString .= <<<EOF
        
     * @var ${type}
     *
EOF;
    }

    if ($groups = $annotationReader->getPropertyGroups($annotations)) {
        $groupsString = '{';

        $keys = \array_keys($groups);
        $last_key = \end($keys);
        foreach ($groups as $key => $group) {
            $groupsString .= $key !== $last_key ? \sprintf('"%s",', $group) : \sprintf('"%s"', $group);
        }

        $annotationsString .= <<<EOF
        
     * @Groups(${groupsString}})
EOF;
    }

    $annotationsString .= <<<EOF
    
     */

EOF;

    return $annotationsString;
}

//
//foreach ($routes as $route => $param) {
//    $defaults = $params->getDefaults();
//
//    if (isset($defaults['_controller'])) {
//        list($controllerService, $controllerMethod) = explode(':', $defaults['_controller']);
//        $controllerObject = $this->container->get($controllerService);
//        $reflectedMethod = new \ReflectionMethod($controllerObject, $controllerMethod);
//
//        // the annotations
//        $annotations = $annotationReader->getMethodAnnotations($reflectedMethod );
//    }
//}

//Annotations
//echo $fileContent;
