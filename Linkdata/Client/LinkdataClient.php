<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Client;

use Stadline\LinkdataClient\ClientHydra\Client\AbstractHydraClient;
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
 * @method ProxyCollection     getUserStat(string $id, array $options = [])
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
class LinkdataClient extends AbstractHydraClient
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
     */
    public function getSimilarActivities(string $activityId, $datatypeId): array
    {
        return $this->getAdapter()->makeRequest(
            'GET',
            \sprintf('/v2/activities/%s/similar/%s?limit=3', $activityId, $datatypeId)
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
        $object =$this->parseResponse(
            $this->getAdapter()->makeRequest(
                'POST',
                \sprintf('/v2/activities'),
                ['Content-Type' => 'application/gpx+xml'],
                $gpxString
            )
        );

        if ($object instanceof ProxyObject) {
            return $object;
        }
    }
}
