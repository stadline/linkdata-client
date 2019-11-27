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
    /**
     * @todo Rename this method
     * @todo Add cache management
     * @todo really implement the securityToken callback
     * @todo simplify this ?
     * @todo add real return type (if possible)
     * @todo tag the 2.0 version
     */
    public static function createClient(
        string $clientClassname,
        string $baseUrl,
        \Closure $getSecurityToken = null
    ): HydraClientInterface
    {
        $reflectClient = new \ReflectionClass($clientClassname);
        if (!$reflectClient->implementsInterface(HydraClientInterface::class)) {
            throw new \RuntimeException(sprintf('The %s must implement HydraClientInterface', $clientClassname));
        }

        $guzzleAdapter = new GuzzleHttpAdapter($baseUrl);
        $iriConverter = new IriConverter(
            $clientClassname::getEntityNamespace(),
            $clientClassname::getIriPrefix()
        );
        $proxyNormalizer = new ProxyObjectNormalizer();
        $serializer = new Serializer([$proxyNormalizer, new ObjectNormalizer()], [new JsonEncoder()]);
        $metadataManager = new MetadataManager($clientClassname::getEntityNamespace());

        $client = new $clientClassname($guzzleAdapter, $iriConverter, $serializer, $metadataManager);

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
