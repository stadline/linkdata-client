<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Client;

use Stadline\LinkdataClient\ClientHydra\Client\AbstractHydraClient;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Type\FormatType;
use Stadline\LinkdataClient\ClientHydra\Type\MethodType;
use Stadline\LinkdataClient\ClientHydra\Utils\Paginator;
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
use Stadline\LinkdataClient\Linkdata\Entity\UserEquipment;
use Stadline\LinkdataClient\Linkdata\Entity\UserMeasure;
use Stadline\LinkdataClient\Linkdata\Entity\UserMeasureGoal;
use Stadline\LinkdataClient\Linkdata\Entity\UserRecord;
use Stadline\LinkdataClient\Linkdata\Entity\UserStorage;
use Stadline\LinkdataClient\Linkdata\Entity\UserSumup;

/**
 * @method Activity            getActivity(string $id, array $options = [])
 * @method Paginator           getActivities(array $options = [])
 * @method Activity            putActivity(Activity $activity, array $options = [])
 * @method Activity            postActivity(Activity $activity, array $options = [])
 * @method void                deleteActivity(string $id, array $options = [])
 * @method ActivityCalculation getActivityCalculation(string $id, array $options = [])
 * @method Paginator           getActivityCalculations(array $options = [])
 * @method Brand               getBrand(string $id, array $options = [])
 * @method Paginator           getBrands(array $options = [])
 * @method Connector           getConnector(string $id, array $options = [])
 * @method Paginator           getConnectors(array $options = [])
 * @method Datatype            getDatatype(string $id, array $options = [])
 * @method Paginator           getDatatypes(array $options = [])
 * @method DeviceModel         getDeviceModel(string $id, array $options = [])
 * @method Paginator           getDeviceModels(array $options = [])
 * @method DeviceNotification  getDeviceNotification(string $id, array $options = [])
 * @method Paginator           getDeviceNotifications(array $options = [])
 * @method DeviceNotification  putDeviceNotification(DeviceNotification $deviceNotification, array $options = [])
 * @method DeviceNotification  postDeviceNotification(DeviceNotification $deviceNotification, array $options = [])
 * @method void                deleteDeviceNotification(string $id, array $options = [])
 * @method Firmware            getFirmware(string $id, array $options = [])
 * @method Paginator           getFirmwares(array $options = [])
 * @method GlobalChallenge     getGlobalChallenge(string $id, array $options = [])
 * @method Paginator           getGlobalChallenges(array $options = [])
 * @method Job                 getJob(string $id, array $options = [])
 * @method Paginator           getJobs(array $options = [])
 * @method Job                 putJob(Job $job, array $options = [])
 * @method User                getUser(string $id, array $options = [])
 * @method Paginator           getUsers(array $options = [])
 * @method Paginator           getUserStat(string $id, array $options = [])
 * @method User                putUser(User $user, array $options = [])
 * @method User                postUser(User $user, array $options = [])
 * @method void                deleteUser(string $id, array $options = [])
 * @method PoiCategory         getPoiCategory(string $id, array $options = [])
 * @method Paginator           getPoiCategories(array $options = [])
 * @method ShareActivity       getShareActivity(string $id, array $options = [])
 * @method Paginator           getShareActivities(array $options = [])
 * @method ShareActivity       postShareActivity(ShareActivity $shareActivity, array $options = [])
 * @method void                deleteShareActivity(string $id, array $options = [])
 * @method ShareUser           getShareUser(string $id, array $options = [])
 * @method Paginator           getShareUsers(array $options = [])
 * @method ShareUser           getShareUserStat(ShareUser $shareUser, array $options = [])
 * @method ShareUser           postShareUser(ShareUser $shareUser, array $options = [])
 * @method void                deleteShareUser(string $id, array $options = [])
 * @method Sport               getSport(string $id, array $options = [])
 * @method Paginator           getSports(array $options = [])
 * @method StorageKey          getStorageKey(string $id, array $options = [])
 * @method Paginator           getStorageKeys(array $options = [])
 * @method Universe            getUniverse(string $id, array $options = [])
 * @method Paginator           getUniverses(array $options = [])
 * @method UserAgreement       getUserAgreement(string $id, array $options = [])
 * @method Paginator           getUserAgreements(array $options = [])
 * @method UserAgreement       putUserAgreement(UserAgreement $userAgreement, array $options = [])
 * @method UserAgreement       postUserAgreement(UserAgreement $serAgreement, array $options = [])
 * @method UserDevice          getUserDevice(string $id, array $options = [])
 * @method Paginator           getUserDevices(array $options = [])
 * @method UserDevice          putUserDevice(UserDevice $userDevice, array $options = [])
 * @method UserDevice          postUserDevice(UserDevice $userDevice, array $options = [])
 * @method void                deleteUserDevice(string $id, array $options = [])
 * @method UserMeasureGoal     getUserMeasureGoal(string $id, array $options = [])
 * @method Paginator           getUserMeasureGoals(array $options = [])
 * @method UserMeasureGoal     putUserMeasureGoal(UserMeasureGoal $userMeasureGoal, array $options = [])
 * @method UserMeasureGoal     postUserMeasureGoal(UserMeasureGoal $userMeasureGoal, array $options = [])
 * @method void                deleteUserMeasureGoal(string $id, array $options = [])
 * @method UserMeasure         getUserMeasure(string $id, array $options = [])
 * @method Paginator           getUserMeasures(array $options = [])
 * @method UserMeasure         putUserMeasure(UserMeasure $userMeasure, array $options = [])
 * @method UserMeasure         postUserMeasure(UserMeasure $userMeasure, array $options = [])
 * @method void                deleteUserMeasure(string $id, array $options = [])
 * @method UserPoi             getUserPoi(string $id, array $options = [])
 * @method Paginator           getUserPois(array $options = [])
 * @method UserPoi             putUserPoi(UserPoi $userPoi, array $options = [])
 * @method UserPoi             postUserPoi(string $userPoi, array $options = [])
 * @method void                deleteUserPoi(string $id, array $options = [])
 * @method UserProgram         getUserProgram(string $id, array $options = [])
 * @method Paginator           getUserPrograms(array $options = [])
 * @method UserProgram         putUserProgram(UserProgram $userProgram, array $options = [])
 * @method UserProgram         postUserProgram(UserProgram $userProgram, array $options = [])
 * @method void                deleteUserProgram(string $id, array $options = [])
 * @method UserRecord          getUserRecord(string $id, array $options = [])
 * @method Paginator           getUserRecords(array $options = [])
 * @method UserRoute           getUserRoute(string $id, array $options = [])
 * @method Paginator           getUserRoutes(array $options = [])
 * @method UserRoute           putUserRoute(UserRoute $userRoute, array $options = [])
 * @method UserRoute           postUserRoute(UserRoute $userRoute, array $options = [])
 * @method void                deleteUserRoute(string $id, array $options = [])
 * @method UserSession         getUserSession(string $id, array $options = [])
 * @method Paginator           getUserSessions(array $options = [])
 * @method UserSession         putUserSession(UserSession $userSession, array $options = [])
 * @method UserSession         postUserSession(UserSession $userSession, array $options = [])
 * @method void                deleteUserSession(string $id, array $options = [])
 * @method UserStorage         getUserStorage(string $id, array $options = [])
 * @method Paginator           getUserStorages(array $options = [])
 * @method UserStorage         putUserStorage(UserStorage $userStorage, array $options = [])
 * @method UserStorage         postUserStorage(UserStorage $userStorage, array $options = [])
 * @method void                deleteUserStorage(string $id, array $options = [])
 * @method UserSumup           getUserSumup(string $id, array $options = [])
 * @method Paginator           getUserSumups(array $options = [])
 * @method UserEquipment       getUserEquipment(string $id, array $options = [])
 * @method Paginator           getUserEquipments(array $options = [])
 * @method UserEquipment       putUserEquipment(UserEquipment $userEquipment, array $options = [])
 * @method UserEquipment       postUserEquipment(UserEquipment $userEquipment, array $options = [])
 * @method void                deleteUserEquipment(string $id, array $options = [])
 */
class LinkdataClient extends AbstractHydraClient
{
    public function getActivityDatastream(string $activityId)
    {
        try {
            return $this->send(MethodType::GET, [
                'customUri' => \sprintf('/activities/%s/datastream', $activityId),
            ]);
        } catch (ClientHydraException $e) {
            return [];
        }
    }

    /**
     * @throws ClientHydraException
     */
    public function getSimilarActivities(string $activityId, $datatypeId)
    {
        return $this->send(MethodType::GET, [
            'customUri' => \sprintf('/activities/%s/similar/%s', $activityId, $datatypeId),
            'filters' => [
                'limit' => 3,
            ],
        ]);
    }

    public function getActivityLocations(string $activityId)
    {
        try {
            return $this->send(MethodType::GET, [
                'customUri' => \sprintf('/activities/%s/locations', $activityId),
            ]);
        } catch (ClientHydraException $e) {
            return [];
        }
    }

    public function getActivityGpx(string $activityId)
    {
        try {
            return $this->send(MethodType::GET, [
                'customUri' => \sprintf('/activities/%s.%s', $activityId, FormatType::GPX),
                'haveToDeserialize' => false,
            ]);
        } catch (ClientHydraException $e) {
            return '';
        }
    }

    /**
     * @throws ClientHydraException
     */
    public function getShareStatistics(string $id): array
    {
        return $this->send(MethodType::GET, [
            'customUri' => \sprintf('/share_users_stats/%s', $id),
        ]);
    }
}
