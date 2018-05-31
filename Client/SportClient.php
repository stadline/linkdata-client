<?php

declare(strict_types=1);

namespace Geonaute\LinkdataClient\Client;

use Geonaute\LinkdataClient\Entity\Sport;
use Geonaute\LinkdataClient\Exception\RequestManagerException;
use Geonaute\LinkdataClient\Utils\GuzzleRequestManager;

class SportClient extends GuzzleRequestManager implements LinkdataGuzzleClientInterface
{
    /**
     * @throws RequestManagerException
     */
    public function getElement(string $sportId, array $filters = []): Sport
    {
        $uri = \sprintf('/v2/sports/%s', $sportId);

        if (!empty($filters)) {
            $uri = $this->addParameters($uri, $filters);
        }

        $response = $this->get($uri);

        return $this->deserialize($response, Sport::class);
    }

    /**
     * @throws RequestManagerException
     */
    public function getElements(array $filters = []): array
    {
        $uri = '/v2/sports';

        if (!empty($filters)) {
            $uri = $this->addParameters($uri, $filters);
        }

        $response = $this->get($uri);

        return $this->deserialize($response, 'array<Geonaute\LinkdataClient\Entity\Sport>');
    }

    private function addParameters(string $uri, array $queryString): string
    {
        $response = \sprintf('%s?', $uri);

        foreach ($queryString as $key => $value) {
            $response = \sprintf('%s=%s', $key, $value);
        }

        return $response;
    }
}
