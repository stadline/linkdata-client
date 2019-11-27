<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Utils;

use SportTrackingDataSdk\ClientHydra\Adapter\GuzzleHttpAdapter;
use SportTrackingDataSdk\ClientHydra\Client\HydraClientInterface;
use SportTrackingDataSdk\ClientHydra\Metadata\MetadataManager;
use SportTrackingDataSdk\ClientHydra\Serializer\ProxyObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ClientGenerator
{
    public static function createClient(
        string $clientClassname,
        string $baseUrl,
        \Closure $getSecurityToken = null
    ): HydraClientInterface {
        $guzzleAdapter = new GuzzleHttpAdapter($baseUrl);
        $iriConverter = new IriConverter(
            (HydraClientInterface::class)(${$clientClassname})::getEntityNamespace(),
            (HydraClientInterface::class)(${$clientClassname})::getIriPrefix()
        );
        $proxyNormalizer = new ProxyObjectNormalizer();
        $serializer = new Serializer([$proxyNormalizer, new ObjectNormalizer()], [new JsonEncoder()]);
        $metadataManager = new MetadataManager((HydraClientInterface::class)(${$clientClassname})::getEntityNamespace());

        $client = new ${$clientClassname}($guzzleAdapter, $iriConverter, $serializer, $metadataManager);

        $proxyNormalizer->setIriConverter($iriConverter);
        $proxyNormalizer->setHydraClient($client);
        $proxyNormalizer->setMetadataManager($metadataManager);

        // Set authentication token
        if ($getSecurityToken) {
            $guzzleAdapter->setDefaultHeader('Authorization',
                \sprintf('Bearer %s', $getSecurityToken())
            );
        }

        return $client;
    }
}
