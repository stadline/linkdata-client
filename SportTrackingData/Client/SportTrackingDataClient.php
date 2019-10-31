<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Client;

use SportTrackingDataSdk\ClientHydra\Client\AbstractHydraClient;
use SportTrackingDataSdk\ClientHydra\Exception\ClientHydraException;
use SportTrackingDataSdk\ClientHydra\Proxy\ProxyCollection;
use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use SportTrackingDataSdk\SportTrackingData\Entity\Activity;

class SportTrackingDataClient extends AbstractHydraClient
{
    public function getActivityDatastream(string $activityId): array
    {
        try {
            return $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/activities/%s/datastream', $activityId)
            )->getContent();
        } catch (ClientHydraException $e) {
            return [];
        }
    }

    /**
     * @throws ClientHydraException
     *
     * @return null|ProxyCollection|ProxyObject
     */
    public function getCurrentUserMeasure(string $userId)
    {
        return $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/users/%s/current_user_measures', $userId)
            )
        );
    }

    /**
     * @throws ClientHydraException
     */
    public function getSimilarActivities(string $activityId, $datatypeId, int $limit = 3): array
    {
        return $this->getAdapter()->makeRequest(
            'GET',
            \sprintf('/v2/activities/%s/similar/%s?limit=%d', $activityId, $datatypeId, $limit)
        )->getContent();
    }

    public function getActivityLocations(string $activityId): array
    {
        try {
            return $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/activities/%s/locations', $activityId)
            )->getContent();
        } catch (ClientHydraException $e) {
            return [];
        }
    }

    public function getActivityGpx(string $activityId): string
    {
        try {
            return $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/activities/%s.%s', $activityId, 'gpx')
            )->getContent();
        } catch (ClientHydraException $e) {
            return '';
        }
    }

    /**
     * @throws ClientHydraException
     */
    public function getShareStatistics(string $id): array
    {
        return $this->getAdapter()->makeRequest(
            'GET',
            \sprintf('/v2/share_users_stats/%s', $id)
        )->getContent();
    }

    public function postActivityGPX($gpxString): Activity
    {
        $object = $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'POST',
                \sprintf('/v2/activities'),
                ['Content-Type' => 'application/gpx+xml'],
                $gpxString
            )
        );

        if ($object instanceof Activity) {
            return $object;
        }
    }

    public function getActivityTCX(string $activityId): string
    {
        try {
            return $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/activities/%s.%s', $activityId, 'tcx')
            )->getContent();
        } catch (ClientHydraException $e) {
            return '';
        }
    }

    public function postActivityTCX($gpxString): Activity
    {
        $object = $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'POST',
                \sprintf('/v2/activities'),
                ['Content-Type' => 'application/tcx+xml'],
                $gpxString
            )
        );

        if ($object instanceof Activity) {
            return $object;
        }
    }

    /**
     * @throws ClientHydraException
     */
    public function getUserStatistics(string $id, $filters = []): array
    {
        return $this->getAdapter()->makeRequest(
            'GET',
            \sprintf('/v2/users/%s/stats%s', $id, $this->getUrlFilters($filters))
        )->getContent();
    }

    /**
     * @throws ClientHydraException
     *
     * @return null|ProxyCollection|ProxyObject
     */
    public function getCurrentUserRecords(string $id, $filters = [])
    {
        return $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/users/%s/current_user_records?%s', $id, $this->iriConverter->formatFilters($filters))
            ));
    }

    /**
     * @throws ClientHydraException
     */
    public function getUserTags(string $userId): array
    {
        try {
            return $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/users/%s/tags', $userId)
            )->getContent();
        } catch (ClientHydraException $e) {
            return [];
        }
    }

    /**
     * @throws ClientHydraException
     *
     * @return null|ProxyCollection|ProxyObject
     */
    public function getFriendActivities(string $friendLdid, ?array $filters)
    {
        return $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/friends/%s/activities?%s', $friendLdid, $this->iriConverter->formatFilters($filters))
            ));
    }

    public function getFriendActivity(string $friendLdid, string $activityId)
    {
        return $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/friends/%s/activities/%s', $friendLdid, $activityId)
            ));
    }

    public function getFriendStatistics(string $friendLdid)
    {
        return
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/friends/%s/stats', $friendLdid)
            )->getContent();
    }

    /**
     * @return array{user_contribution:int, average_contribution:int}
     */
    public function getUserGlobalChallengeContribution(string $userId, string $globalChallengeId): array
    {
        return
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/users/%s/global_challenges/%s/contributions', $userId, $globalChallengeId)
            )->getContent();
    }

    /* ------ */

    /**
     * @deprecated replace by formatFiltersForUrl
     */
    private function getUrlFilters(?array $filters)
    {
        $urlFilters = '';
        if (null !== $filters && !empty($filters)) {
            foreach ($filters['filters'] as $key => $filter) {
                $urlFilters .= \sprintf('&%s=%s', $key, $filter);
            }
            $urlFilters = \sprintf('?%s', \ltrim($urlFilters, '&'));
        }

        return $urlFilters;
    }

    /**
     * @throws ClientHydraException
     */
    public function getAutocompleteEquipement(string $parameter, string $query): array
    {
        return $this->getAdapter()->makeRequest(
            'GET',
            \sprintf('/v2/user_equipments/autocomplete/%s/%s', $parameter, $query)
        )->getContent();
    }
}
