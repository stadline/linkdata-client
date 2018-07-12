<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Handler;

use Pagerfanta\Pagerfanta;
use Stadline\LinkdataClient\src\ClientHydra\Adapter\GuzzleAdapter;
use Stadline\LinkdataClient\src\ClientHydra\Exception\HandlerException\HandlerException;
use Stadline\LinkdataClient\src\ClientHydra\Exception\RequestException\RequestException;
use Stadline\LinkdataClient\src\ClientHydra\Exception\SerializerException\SerializerException;
use Stadline\LinkdataClient\src\ClientHydra\Type\HydraType;
use Stadline\LinkdataClient\src\ClientHydra\Utils\Serializator;
use Stadline\LinkdataClient\src\ClientHydra\Utils\UriConverter;
use Stadline\LinkdataClient\src\Linkdata\Adapter\LinkdataAdapter;

class RequestHandler
{
    private $config;
    private $guzzleAdapter;
    private $serializer;
    private $uriConverter;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->guzzleAdapter = new GuzzleAdapter($config);
        $this->serializer = new Serializator($config);
        $this->uriConverter = new UriConverter($config);
    }

    /**
     * @throws HandlerException
     */
    public function handleRequest(array $args)
    {
        $results = [[]];
        $content = $this->retrieveData($args);
        $nbResult = $this->getNbResult($content);

        if ($nbResult <= 1) {
            return  $content[0];
        }

        $results[] = $content;
        $nextPage = (int) $content['extra']['next_page'];

        while (0 !== $nextPage) {
            $this->setNextPage($args, $nextPage);
            $content = $this->retrieveData($args);

            $results[] = $content;
            $nextPage = (int) $content['extra']['next_page'];
        }

        $results = \array_merge(...$results);

        unset($results['extra']);

        $adapter = new LinkdataAdapter($results);
        $paginator = new Pagerfanta($adapter);
        $paginator->setMaxPerPage($this->config['max_result_per_page']);

        return $paginator;
    }

    /**
     * @throws HandlerException
     */
    private function retrieveData(array $args): array
    {
        try {
            $requestResponse = $this->guzzleAdapter->makeRequest(
                $args['method'],
                $args['uri'],
                $args['headers'],
                $args['body']
            );
        } catch (RequestException $e) {
            throw new HandlerException('An error occurred during processing request.', $e);
        }

        try {
            $content = $this->serializer->deserialize($requestResponse);
        } catch (SerializerException $e) {
            throw new HandlerException('An error occurred during deserialization.', $e);
        }

        $extra = [
            'first_page' => null,
            'next_page' => null,
            'last_page' => null,
        ];

        if ($this->serializer->hasNode($requestResponse, HydraType::VIEW)) {
            $node = $this->serializer->getNodeValues($requestResponse, HydraType::VIEW);

            $extra = [
                'first_page' => null === $node[HydraType::FIRST_PAGE] ? null : $this->uriConverter->getUriParam('page', $node[HydraType::FIRST_PAGE]),
                'next_page' => null === $node[HydraType::NEXT_PAGE] ? null : $this->uriConverter->getUriParam('page', $node[HydraType::NEXT_PAGE]),
                'last_page' => null === $node[HydraType::LAST_PAGE] ? null : $this->uriConverter->getUriParam('page', $node[HydraType::LAST_PAGE]),
            ];
        }

        $content['extra'] = $extra;

        return $content;
    }

    private function getNbResult(array $results): int
    {
        $response = \count($results);

        return \array_key_exists('extra', $results) ? $response - 1 : $response;
    }

    private function setNextPage(array &$args, int $nextPage): void
    {
        $page = $this->uriConverter->getUriParam('page', $args['uri']);

        if (null === $page) {
            $this->uriConverter->addUriParam('page', (string) $nextPage, $args['uri']);

            return;
        }

        $this->uriConverter->updateUriParamValue('page', (string) $nextPage, $args['uri']);
    }
}
