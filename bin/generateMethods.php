#!/usr/bin/env php
<?php

// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

set_time_limit(0);

require_once('./vendor/autoload.php');

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

$loader = require __DIR__ . '/../vendor/autoload.php';
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpFoundation\Request;


class UniversalAnnotationReader extends AnnotationReader
{
    /**
     * Get type of property from property declaration
     *
     * @param \ReflectionProperty $property
     *
     * @return null|string
     */
    public function getPropertyType(\ReflectionProperty $property)
    {
        $doc = $property->getDocComment();
        preg_match_all('#@var (.*?)\n#s', $doc, $annotations);
        return $annotations[1][0];
    }
}


if (!isset($argv[1])) {
    echo "Error : missing filename parameter" . PHP_EOL;
    exit(1);
}

if (!file_exists($argv[1])) {
    echo "Error : File \"$argv[1]\" not found" . PHP_EOL;
    exit(1);
}

$fileContent = file_get_contents($argv[1]);
require_once $argv[1];


preg_match('/^namespace (.+);/m', $fileContent, $matches);
$namespace = $matches[1];
preg_match('/^class (.+)( extends?)(.*)/m', $fileContent, $matches);
$classname = $namespace . "\\" . $matches[1];


$annotationReader = new UniversalAnnotationReader();
$reflectedClass = new \ReflectionClass($classname);

echo "/**" . PHP_EOL;
foreach ($reflectedClass->getProperties() as $reflectionProperty) {
    // the annotations
    $annotations = $annotationReader->getPropertyAnnotations($reflectionProperty);
    $annotation = $annotationReader->getPropertyType($reflectionProperty);

//    var_dump($reflectionProperty->getName());
//    var_dump($annotation);
//    var_dump($annotations);
//    die();


    $propertyName = $reflectionProperty->getName();

    $isNullable = substr($annotation, 0, 1) === '?';
    $realType = $isNullable ? substr($annotation, 1) : $annotation;

    // Type
    if ($isNullable) {
        $stringType = $realType . '|null';
    } else {
        $stringType = $realType;
    }

    // getter
    $getterPrefix = 'get';
    if ($realType === 'bool' || $realType === 'boolean') {
        $getterPrefix = 'is';
    }
    $stringGetter = $getterPrefix . ucfirst($propertyName) . '()';

    // setter
    $stringSetter = 'set' . ucfirst($propertyName) . '(' . $stringType . ' $' . $propertyName . ')';
    echo sprintf(' * @method %s %s', $stringType, $stringGetter) . PHP_EOL;
    echo sprintf(' * @method void %s', $stringSetter) . PHP_EOL;
}
echo " */" . PHP_EOL;

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