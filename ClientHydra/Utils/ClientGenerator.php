<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Utils;

use SportTrackingDataSdk\ClientHydra\Adapter\GuzzleHttpAdapter;
use SportTrackingDataSdk\ClientHydra\Client\HydraClientInterface;
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
        string $authorizationToken = null
    ): HydraClientInterface {
        $reflectClient = new \ReflectionClass($clientClassname);
        if (!$reflectClient->implementsInterface(HydraClientInterface::class)) {
            throw new \RuntimeException(\sprintf('The %s must implement HydraClientInterface', $clientClassname));
        }

        $guzzleAdapter = new GuzzleHttpAdapter($baseUrl);
        $proxyNormalizer = new ProxyObjectNormalizer();
        $serializer = new Serializer([$proxyNormalizer, new ObjectNormalizer()], [new JsonEncoder()]);

        /** @var HydraClientInterface $client */
        $client = new $clientClassname($guzzleAdapter, $serializer);
        $proxyNormalizer->setHydraClient($client);

        // Set authentication token
        if ($authorizationToken) {
            $client->setAuthorizationToken($authorizationToken);
        }

        return $client;
    }
}
