<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Exception\UriException\FormatException;

class UriResolver
{
    /**
     * @throws FormatException
     */
    public function validateClassByName(string $className, string $namespace): string
    {
        // first, try to get the singular class
        $class = Inflector::singularize($className);

        if (\class_exists(\sprintf('%s\%s', $namespace, $class))) {
            return $class;
        }

        // second, if singular class not found, try to get the class in the plural
        $class = Inflector::pluralize($className);

        if (\class_exists(\sprintf('%s\%s', $namespace, $class))) {
            return $class;
        }

        // third, if singular and plural class not found, try to parse it to retrieve the correct name
        $splitedClassName = $this->parseUri($className);
        \array_pop($splitedClassName);

        if (empty($splitedClassName)) {
            throw new FormatException('The class you try to retrieve does not exist.');
        }

        return $this->validateClassByName(\implode('', $splitedClassName), $namespace);
    }

    private function parseUri(string $className): array
    {
        // get each part of the uri by uppercase
        return \preg_split('/(?=[A-Z])/', $className, 0, PREG_SPLIT_NO_EMPTY);
    }
}
