#!/usr/bin/env php
<?php

// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

\set_time_limit(0);

require_once './vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';
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
    public function getPropertyType(\ReflectionProperty $property)
    {
        $doc = $property->getDocComment();
        \preg_match_all('#@var (.*?)\n#s', $doc, $annotations);

        return $annotations[1][0];
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

// Vars
$baseLd2Path = $argv[1];
$clientExtractFilename = 'client-extract.json';
$fileContent = \file_get_contents(\sprintf('%s/%s', $baseLd2Path, $clientExtractFilename));
$extractConf = \json_decode($fileContent, true);

// Require ld2 autoload
require_once \sprintf('%s/%s', $baseLd2Path, $extractConf['autoload_path']);

$annotationReader = new UniversalAnnotationReader();

main($baseLd2Path, $extractConf);

function main(string $baseLd2Path, array $extractConf)
{
    foreach ($extractConf['entity_directories'] as $entityPath) {

        $finder = new \Symfony\Component\Finder\Finder();
        $files = $finder->files()->name('*.php')->in(\sprintf('%s/%s', $baseLd2Path, $entityPath));

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $entityContent = processEntity(\file_get_contents($file->getRealPath()));

            var_dump($entityContent);die;
        }
    }
}

function processEntity(string $entityContent): string
{
    global $annotationReader;

    $content = <<<EOF
<?php
        
declare(strict_types=1);
        
namespace Stadline\LinkdataClient\Linkdata\Entity;


EOF;

    \preg_match('/^namespace (.+);/m', $entityContent, $matches);
    $namespace = $matches[1];
    \preg_match('/^class ([a-zA-Z0-9\\_]+)/m', $entityContent, $matches);
    $classname = $namespace.'\\'.$matches[1];

    $reflectedClass = new \ReflectionClass($classname);

    $content .= generateClassDoc($reflectedClass->getProperties());


    return $content;


    foreach ($reflectedClass->getProperties() as $reflectionProperty) {

        // the annotations
        $annotations = $annotationReader->getPropertyAnnotations($reflectionProperty);
        $annotation = $annotationReader->getPropertyType($reflectionProperty);

        $propertyName = $reflectionProperty->getName();

        $isNullable = '?' === \substr($annotation, 0, 1);
        $realType = $isNullable ? \substr($annotation, 1) : $annotation;

        // Type
        if ($isNullable) {
            $stringType = $realType . '|null';
        } else {
            $stringType = $realType;
        }

        // getter
        $getterPrefix = 'get';
        if ('bool' === $realType || 'boolean' === $realType) {
            $getterPrefix = 'is';
        }
        $stringGetter = $getterPrefix . \ucfirst($propertyName) . '()';

        // setter
        $stringSetter = 'set' . \ucfirst($propertyName) . '(' . $stringType . ' $' . $propertyName . ')';
        echo \sprintf(' * @method %s %s', $stringType, $stringGetter) . PHP_EOL;
        echo \sprintf(' * @method void %s', $stringSetter) . PHP_EOL;

    }
    echo ' */'.PHP_EOL;


}


function generateClassDoc(array $reflectionProperties): string
{
    global $annotationReader;

    $classDoc = "/**".PHP_EOL;

    foreach ($reflectionProperties as $reflectionProperty) {

        // the annotations
        $annotations = $annotationReader->getPropertyAnnotations($reflectionProperty);
        $annotation = $annotationReader->getPropertyType($reflectionProperty);

        $propertyName = $reflectionProperty->getName();

        $isNullable = '?' === \substr($annotation, 0, 1);
        $realType = $isNullable ? \substr($annotation, 1) : $annotation;

        // Type
        if ($isNullable) {
            $stringType = $realType . '|null';
        } else {
            $stringType = $realType;
        }

        // getter
        $getterPrefix = 'get';
        if ('bool' === $realType || 'boolean' === $realType) {
            $getterPrefix = 'is';
        }
        $stringGetter = $getterPrefix . \ucfirst($propertyName) . '()';

        // setter
        $stringSetter = 'set' . \ucfirst($propertyName) . '(' . $stringType . ' $' . $propertyName . ')';
        $classDoc .= \sprintf(' * @method %s %s', $stringType, $stringGetter) . PHP_EOL;
        $classDoc .= \sprintf(' * @method void %s', $stringSetter) . PHP_EOL;

    }
    $classDoc .= ' */'.PHP_EOL;

    return $classDoc;
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




