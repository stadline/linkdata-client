<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Client;

use Stadline\LinkdataClient\ClientHydra\Client\HydraClient;
use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Utils\Paginator;
use Stadline\LinkdataClient\Linkdata\Entity\Activity;
use Stadline\LinkdataClient\Linkdata\Entity\Sport;
use Stadline\LinkdataClient\Linkdata\Entity\Universe;
use Stadline\LinkdataClient\Linkdata\Entity\User;

/**
 * @method Activity            getActivity(string $id, array $options = [])
 * @method Paginator           getActivityDatastream(string $id, array $options = [])
 * @method Paginator           getActivityLocations(string $id, array $options = [])
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
 */
class LinkdataClient extends HydraClient
{
    /**
     * @throws ClientHydraException
     */
    public function __call(string $method, array $args)
    {
        return $this->send($method, $args);
    }
}
