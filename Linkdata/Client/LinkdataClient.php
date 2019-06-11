<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Client;

use Stadline\LinkdataClient\ClientHydra\Client\AbstractHydraClient;
use Stadline\LinkdataClient\ClientHydra\Client\HydraClientInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyCollection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\Linkdata\Entity\Activity;
use Stadline\LinkdataClient\Linkdata\Entity\Brand;
use Stadline\LinkdataClient\Linkdata\Entity\Datatype;
use Stadline\LinkdataClient\Linkdata\Entity\DeviceModel;
use Stadline\LinkdataClient\Linkdata\Entity\GlobalChallenge;
use Stadline\LinkdataClient\Linkdata\Entity\ShareUser;
use Stadline\LinkdataClient\Linkdata\Entity\Sport;
use Stadline\LinkdataClient\Linkdata\Entity\StorageKey;
use Stadline\LinkdataClient\Linkdata\Entity\Universe;
use Stadline\LinkdataClient\Linkdata\Entity\User;
use Stadline\LinkdataClient\Linkdata\Entity\UserDevice;
use Stadline\LinkdataClient\Linkdata\Entity\UserMeasure;
use Stadline\LinkdataClient\Linkdata\Entity\UserMeasureGoal;
use Stadline\LinkdataClient\Linkdata\Entity\UserRecord;
use Stadline\LinkdataClient\Linkdata\Entity\UserStorage;
use Stadline\LinkdataClient\Linkdata\Entity\UserSumup;

/**
 * @method Activity            getActivity(string $id, array $options = [])
 * @method ProxyCollection     getActivities(array $options = [])
 * @method Activity            putActivity(Activity $activity, array $options = [])
 * @method Activity            postActivity(Activity $activity, array $options = [])
 * @method void                deleteActivity(string $id, array $options = [])
 * @method ActivityCalculation getActivityCalculation(string $id, array $options = [])
 * @method ProxyCollection     getActivityCalculations(array $options = [])
 * @method Brand               getBrand(string $id, array $options = [])
 * @method ProxyCollection     getBrands(array $options = [])
 * @method Connector           getConnector(string $id, array $options = [])
 * @method ProxyCollection     getConnectors(array $options = [])
 * @method Datatype            getDatatype(string $id, array $options = [])
 * @method ProxyCollection     getDatatypes(array $options = [])
 * @method DeviceModel         getDeviceModel(string $id, array $options = [])
 * @method ProxyCollection     getDeviceModels(array $options = [])
 * @method DeviceNotification  getDeviceNotification(string $id, array $options = [])
 * @method ProxyCollection     getDeviceNotifications(array $options = [])
 * @method DeviceNotification  putDeviceNotification(DeviceNotification $deviceNotification, array $options = [])
 * @method DeviceNotification  postDeviceNotification(DeviceNotification $deviceNotification, array $options = [])
 * @method void                deleteDeviceNotification(string $id, array $options = [])
 * @method Firmware            getFirmware(string $id, array $options = [])
 * @method ProxyCollection     getFirmwares(array $options = [])
 * @method GlobalChallenge     getGlobalChallenge(string $id, array $options = [])
 * @method ProxyCollection     getGlobalChallenges(array $options = [])
 * @method Job                 getJob(string $id, array $options = [])
 * @method ProxyCollection     getJobs(array $options = [])
 * @method Job                 putJob(Job $job, array $options = [])
 * @method User                getUser(string $id, array $options = [])
 * @method ProxyCollection     getUsers(array $options = [])
 * @method User                putUser(User $user, array $options = [])
 * @method User                postUser(User $user, array $options = [])
 * @method void                deleteUser(string $id, array $options = [])
 * @method PoiCategory         getPoiCategory(string $id, array $options = [])
 * @method ProxyCollection     getPoiCategories(array $options = [])
 * @method ShareActivity       getShareActivity(string $id, array $options = [])
 * @method ProxyCollection     getShareActivities(array $options = [])
 * @method ShareActivity       postShareActivity(ShareActivity $shareActivity, array $options = [])
 * @method void                deleteShareActivity(string $id, array $options = [])
 * @method ShareUser           getShareUser(string $id, array $options = [])
 * @method ProxyCollection     getShareUsers(array $options = [])
 * @method ShareUser           getShareUserStat(ShareUser $shareUser, array $options = [])
 * @method ShareUser           postShareUser(ShareUser $shareUser, array $options = [])
 * @method void                deleteShareUser(string $id, array $options = [])
 * @method Sport               getSport(string $id, array $options = [])
 * @method ProxyCollection     getSports(array $options = [])
 * @method StorageKey          getStorageKey(string $id, array $options = [])
 * @method ProxyCollection     getStorageKeys(array $options = [])
 * @method Universe            getUniverse(string $id, array $options = [])
 * @method ProxyCollection     getUniverses(array $options = [])
 * @method UserAgreement       getUserAgreement(string $id, array $options = [])
 * @method ProxyCollection     getUserAgreements(array $options = [])
 * @method UserAgreement       putUserAgreement(UserAgreement $userAgreement, array $options = [])
 * @method UserAgreement       postUserAgreement(UserAgreement $serAgreement, array $options = [])
 * @method UserDevice          getUserDevice(string $id, array $options = [])
 * @method ProxyCollection     getUserDevices(array $options = [])
 * @method UserDevice          putUserDevice(UserDevice $userDevice, array $options = [])
 * @method UserDevice          postUserDevice(UserDevice $userDevice, array $options = [])
 * @method void                deleteUserDevice(string $id, array $options = [])
 * @method UserMeasureGoal     getUserMeasureGoal(string $id, array $options = [])
 * @method ProxyCollection     getUserMeasureGoals(array $options = [])
 * @method UserMeasureGoal     putUserMeasureGoal(UserMeasureGoal $userMeasureGoal, array $options = [])
 * @method UserMeasureGoal     postUserMeasureGoal(UserMeasureGoal $userMeasureGoal, array $options = [])
 * @method void                deleteUserMeasureGoal(string $id, array $options = [])
 * @method UserMeasure         getUserMeasure(string $id, array $options = [])
 * @method ProxyCollection     getUserMeasures(array $options = [])
 * @method UserMeasure         putUserMeasure(UserMeasure $userMeasure, array $options = [])
 * @method UserMeasure         postUserMeasure(UserMeasure $userMeasure, array $options = [])
 * @method void                deleteUserMeasure(string $id, array $options = [])
 * @method UserPoi             getUserPoi(string $id, array $options = [])
 * @method ProxyCollection     getUserPois(array $options = [])
 * @method UserPoi             putUserPoi(UserPoi $userPoi, array $options = [])
 * @method UserPoi             postUserPoi(string $userPoi, array $options = [])
 * @method void                deleteUserPoi(string $id, array $options = [])
 * @method UserProgram         getUserProgram(string $id, array $options = [])
 * @method ProxyCollection     getUserPrograms(array $options = [])
 * @method UserProgram         putUserProgram(UserProgram $userProgram, array $options = [])
 * @method UserProgram         postUserProgram(UserProgram $userProgram, array $options = [])
 * @method void                deleteUserProgram(string $id, array $options = [])
 * @method UserRecord          getUserRecord(string $id, array $options = [])
 * @method ProxyCollection     getUserRecords(array $options = [])
 * @method UserRoute           getUserRoute(string $id, array $options = [])
 * @method ProxyCollection     getUserRoutes(array $options = [])
 * @method UserRoute           putUserRoute(UserRoute $userRoute, array $options = [])
 * @method UserRoute           postUserRoute(UserRoute $userRoute, array $options = [])
 * @method void                deleteUserRoute(string $id, array $options = [])
 * @method UserSession         getUserSession(string $id, array $options = [])
 * @method ProxyCollection     getUserSessions(array $options = [])
 * @method UserSession         putUserSession(UserSession $userSession, array $options = [])
 * @method UserSession         postUserSession(UserSession $userSession, array $options = [])
 * @method void                deleteUserSession(string $id, array $options = [])
 * @method UserStorage         getUserStorage(string $id, array $options = [])
 * @method ProxyCollection     getUserStorages(array $options = [])
 * @method UserStorage         putUserStorage(UserStorage $userStorage, array $options = [])
 * @method UserStorage         postUserStorage(UserStorage $userStorage, array $options = [])
 * @method void                deleteUserStorage(string $id, array $options = [])
 * @method UserSumup           getUserSumup(string $id, array $options = [])
 * @method ProxyCollection     getUserSumups(array $options = [])
 */
class LinkdataClient extends AbstractHydraClient implements HydraClientInterface
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

    public function getCurrentUserMeasure(string $userId): ProxyCollection
    {
        return $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/user_measures/%s/current', $userId)
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
     */
    public function getCurrentUserRecords(string $id, $filters = []): ProxyCollection
    {
        return $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/user_records/%s/current%s', $id, $this->getUrlFilters($filters))
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


    public function getUsersGlobalChallenges(string $ldid, string $country, string $orderStartedAt = 'DESC', bool $active = true)
    {
        // todo : waiting ld2 dev
        // die

        #return json_decode('{
        #    "globalChallenge": {
        #        "id": "eu29f59bcf725806c915",
        #        "targetDatatype": "/v2/datatypes/5",
        #        "translatedBeforeMessage": null,
        #        "translatedCurrentMessage": null,
        #        "translatedAfterMessage": null,
        #        "publishDate": null,
        #        "startedAt": "2019-05-28T08:00:00+00:00",
        #        "endedAt": null,
        #        "target": 10000,
        #        "result": 2000,
        #        "imageUrl": "https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/training-pace-calculator-1534874738.jpg",
        #        "translatedNames": {
        #                "de": "Gleitschirmfliegen",
        #            "en": "Paragliding",
        #            "es": "Parapente",
        #            "fr": "Parapente",
        #            "hu": "Siklóernyős",
        #            "it": "Parapendio",
        #            "nl": "Paragliding",
        #            "pl": "Paralotniarstwo",
        #            "pt": "Parapente",
        #            "ru": "Параплан",
        #            "zh": "滑翔伞"
        #        },
        #        "active": true,
        #        "createdAt": "2019-05-28T08:34:55+00:00",
        #        "updatedAt": "2019-05-28T09:07:26+00:00",
        #        "sport": null,
        #        "country": "fr"
        #    },
        #    "userContribution": 0,
        #    "averageContribution": 0
        #}', true);


        $filters = [
            'ldid' => $ldid,
            'country' => $country,
            'order[startedAt]' => $orderStartedAt,
            'active' => $active,
        ];

        return $this->getAdapter()->makeRequest(
            'GET',
            \sprintf('/v2/users/%s/global_challenge%s', $ldid, $this->getUrlFilters($filters))
        )->getContent();
    }

    public function getFriendActivities(string $friendLdid, ?array $filters)
    {
        return $this->parseResponse(
            $this->getAdapter()->makeRequest(
                'GET',
                \sprintf('/v2/friends/%s/activities%s', $friendLdid, $this->formatFiltersForUrl($filters))
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

    private function formatFiltersForUrl(?array $filters)
    {
        $response = '';
        if (null !== $filters && !empty($filters)) {
            $response = '?';
            foreach ($filters as $key => $filter) {
                if ($filter instanceof ProxyObject) {
                    $filter = $this->getIriFromObject($filter);
                    $response .= \sprintf('%s=%s&', $key, $filter);
                } elseif (\is_array($filter)) {
                    foreach ($filter as $arrayVal) {
                        $response .= \sprintf('%s[]=%s&', $key, $arrayVal);
                    }
                } elseif (null === $filter) {
                    $response .= \sprintf('%s&', $key);
                } else {
                    $response .= \sprintf('%s=%s&', $key, $filter);
                }
            }

            $response = \substr($response, 0, -1);
        }

        return $response;
    }
}
