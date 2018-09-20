<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Handler;

use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Adapter\JsonResponse;
use Stadline\LinkdataClient\ClientHydra\Adapter\RawResponse;
use Stadline\LinkdataClient\ClientHydra\Exception\HandlerException;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException;
use Stadline\LinkdataClient\ClientHydra\Exception\SerializerException;
use Stadline\LinkdataClient\ClientHydra\Utils\Serializator;

class RequestHandler
{
    private $adapter;
    private $serializator;
    private $paginationHandler;

    public function __construct(
        AdapterInterface $adapter,
        Serializator $serializator,
        PaginationHandler $paginationHandler
    ) {
        $this->adapter = $adapter;
        $this->serializator = $serializator;
        $this->paginationHandler = $paginationHandler;
    }

    /**
     * @throws HandlerException
     */
    public function handleRequest(array $args)
    {
        $results = [[]];
        $content = $this->retrieveData($args);

        // Item Case
        if (\is_object($content)) {
            return $content;
        }

        $nbResult = $this->getNbResult($content[0]);

        if ($nbResult > 1) {
            $results[] = $content[0];
            $nextPage = (int) $content['extra']['next_page'];

            while (0 !== $nextPage) {
                $this->paginationHandler->setNextPage($args, $nextPage);
                $content = $this->retrieveData($args);

                $results[] = $content[0];
                $nextPage = (int) $content['extra']['next_page'];
            }

            $results = \array_merge(...$results);

            unset($results['extra']);

            return $this->paginationHandler->handlePagination($results);
        }

        if (1 === $nbResult) {
            return $content[0];
        }

        return [];
    }

    /**
     * @throws HandlerException
     */
    private function retrieveData(array $args)
    {
        try {
            $requestResponse = $this->adapter->makeRequest(
                $args['method'],
                $args['uri'],
                $args['headers'],
                $args['body']
            );
        } catch (RequestException $e) {
            throw new HandlerException('An error occurred during processing request.', $e);
        }

        // Not json : cannot be deserialize
        if (!$requestResponse instanceof JsonResponse) {
            return $requestResponse->getContent();
        }

        try {
            $content = $this->serializator->deserialize($requestResponse);
        } catch (SerializerException $e) {
            throw new HandlerException('An error occurred during deserialization.', $e);
        }

        if (empty($content)) {
            return $content;
        }

//        if ($this->paginationHandler->haveToPaginate($content)) {
//            return $this->paginationHandler->addExtraNode($content, $requestResponse);
//        }

        return $content;
    }

    private function getNbResult(array $results): int
    {
        $response = \count($results);

        return \array_key_exists('extra', $results) ? $response - 1 : $response;
    }
}
