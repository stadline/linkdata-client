<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Handler;

use Stadline\LinkdataClient\ClientHydra\Type\HydraType;
use Stadline\LinkdataClient\ClientHydra\Utils\Paginator;
use Stadline\LinkdataClient\ClientHydra\Utils\Serializator;
use Stadline\LinkdataClient\ClientHydra\Utils\UriConverter;
use Stadline\LinkdataClient\Linkdata\Adapter\LinkdataAdapter;

class PaginationHandler
{
    private $serializer;
    private $uriConverter;
    private $maxResultPerPage;

    public function __construct(Serializator $serializator, UriConverter $uriConverter, int $maxResultPerPage)
    {
        $this->serializer = $serializator;
        $this->uriConverter = $uriConverter;
        $this->maxResultPerPage = $maxResultPerPage;
    }

    public function handlePagination(array $content): Paginator
    {
        $adapter = new LinkdataAdapter($content);
        $paginator = new Paginator($adapter);
        $paginator->setMaxPerPage($this->maxResultPerPage);

        return $paginator;
    }

    public function addExtraNode(array $content, string $requestResponse): array
    {
        $response[] = $content;

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

        $response['extra'] = $extra;

        return $response;
    }

    public function setNextPage(array &$args, int $nextPage): void
    {
        $page = $this->uriConverter->getUriParam('page', $args['uri']);

        if (null === $page) {
            $this->uriConverter->addUriParam('page', (string) $nextPage, $args['uri']);

            return;
        }

        $this->uriConverter->updateUriParamValue('page', (string) $nextPage, $args['uri']);
    }

    public function haveToPaginate($content): bool
    {
        return \is_array($content);
    }
}
