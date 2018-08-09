<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Handler;

use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\HandlerException\HandlerException;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException\RequestException;
use Stadline\LinkdataClient\ClientHydra\Exception\SerializerException\SerializerException;
use Stadline\LinkdataClient\ClientHydra\Utils\Serializator;

class RequestHandler
{
    private $adapter;
    private $serializer;
    private $paginationHandler;

    public function __construct(
        AdapterInterface $adapter,
        Serializator $serializator,
        PaginationHandler $paginationHandler
    ) {
        $this->adapter = $adapter;
        $this->serializer = $serializator;
        $this->paginationHandler = $paginationHandler;
    }

    /**
     * @throws HandlerException
     */
    public function handleRequest(array $args)
    {
        $results = [[]];
        $content = $this->retrieveData($args);

        if (\is_object($content)) {
            return $content;
        }

        $nbResult = $this->getNbResult($content);

        if (1 > $nbResult) {
            return [];
        }

        if ($nbResult > 1) {
            $results[] = $content;
            $nextPage = (int) $content['extra']['next_page'];

            while (0 !== $nextPage) {
                $this->paginationHandler->setNextPage($args, $nextPage);
                $content = $this->retrieveData($args);

                $results[] = $content;
                $nextPage = (int) $content['extra']['next_page'];
            }

            $results = \array_merge(...$results);

            unset($results['extra']);
        }

        return $this->paginationHandler->handlePagination($results);
    }

    /**
     * @throws HandlerException
     */
    private function retrieveData(array $args)
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

        if ($this->paginationHandler->haveToPaginate($content)) {
            return $this->paginationHandler->addExtraNode($content, $requestResponse);
        }

        return $content;
    }

    private function getNbResult(array $results): int
    {
        $response = \count($results);

        return \array_key_exists('extra', $results) ? $response - 1 : $response;
    }
}