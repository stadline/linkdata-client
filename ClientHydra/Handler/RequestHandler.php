<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Handler;

use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\HandlerException\HandlerException;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException\RequestException;
use Stadline\LinkdataClient\ClientHydra\Exception\SerializerException\SerializerException;
use Stadline\LinkdataClient\ClientHydra\Type\HydraType;
use Stadline\LinkdataClient\ClientHydra\Utils\Paginator;
use Stadline\LinkdataClient\ClientHydra\Utils\Serializator;
use Stadline\LinkdataClient\ClientHydra\Utils\UriConverter;
use Stadline\LinkdataClient\Linkdata\Adapter\LinkdataAdapter;

class RequestHandler
{
    private $adapter;
    private $serializer;
    private $uriConverter;
    private $maxResultPerPage;

    public function __construct(
        AdapterInterface $adapter,
        Serializator $serializator,
        UriConverter $uriConverter,
        string $maxResultPerPage
    ) {
        $this->adapter = $adapter;
        $this->serializer = $serializator;
        $this->uriConverter = $uriConverter;
        $this->maxResultPerPage = $maxResultPerPage;
    }

    /**
     * @throws HandlerException
     */
    public function handleRequest(array $args)
    {
        $results = [[]];
        $content = $this->retrieveData($args);
        $nbResult = $this->getNbResult($content);

        if ($nbResult > 1) {
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
            $paginator = new Paginator($adapter);
            $paginator->setMaxPerPage($this->maxResultPerPage);

            return $paginator;
        }

        if (1 === $nbResult) {
            return $content[0];
        }

        return [];
    }

    /**
     * @throws HandlerException
     */
    private function retrieveData(array $args): array
    {
        try {
            $requestResponse = $this->adapter->makeRequest(
                $args['method'],
                $args['baseUrl'],
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

        if (empty($content)) {
            return [];
        }

        $extra = [
            'first_page' => null,
            'next_page' => null,
            'last_page' => null,
        ];

        if ($this->serializer->hasNode($requestResponse, HydraType::VIEW)) {
            $node = $this->serializer->getNodeValues($requestResponse, HydraType::VIEW);

            $extra = [
                'first_page' => $this->serializer->hasNode(\json_encode($node), HydraType::FIRST_PAGE) ?
                    $this->uriConverter->getUriParam('page', $node[HydraType::FIRST_PAGE]) :
                    null,
                'next_page' => $this->serializer->hasNode(\json_encode($node), HydraType::NEXT_PAGE) ?
                    $this->uriConverter->getUriParam('page', $node[HydraType::NEXT_PAGE]) :
                    null,
                'last_page' => $this->serializer->hasNode(\json_encode($node), HydraType::LAST_PAGE) ?
                    $this->uriConverter->getUriParam('page', $node[HydraType::LAST_PAGE]) :
                    null,
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
