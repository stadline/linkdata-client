<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Utils;


class UriConverter
{
    public function formateUri(string $method, array $args): array
    {
        $response = [];
        $config = $this->loadConfiguration();

        // get each parts of method splited by uppercase
        $splitedUri = preg_split('/(?=[A-Z])/', $method, -1, PREG_SPLIT_NO_EMPTY);

        // extract the method
        $response['method'] = array_shift($splitedUri);
        // if we have an id (for querying one occurence), extract it and place it at the end of the uri
        $queryString = isset($args['id']) ? \sprintf('/%s', $args['id']) : '';

        if (1 === \count($splitedUri)) {
            $response['uri'] = \sprintf('%s/%s%s', $config->base_url, strtolower($splitedUri[0]), $queryString);

            return $response;
        }

        $uri = strtolower(array_shift($splitedUri));

        foreach ($splitedUri as $item) {
            $uri .= str_replace($item, substr($item, 0), sprintf('_%s', strtolower($item)));
        }

        $response['uri'] = \sprintf('%s/%s%s', $config->base_url, $uri, $queryString);

        return $uri;
    }

    private function loadConfiguration()
    {
        $json = file_get_contents(__DIR__.'/../Config/config.json');

        return json_decode($json);
    }
}
