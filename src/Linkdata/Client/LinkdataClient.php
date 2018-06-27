<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Client;

use Psr\Http\Message\ResponseInterface;
use Stadline\LinkdataClient\src\ClientHydra\Client\HydraClient;
use Stadline\LinkdataClient\src\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\src\Linkdata\Proxy\ProxyManager;
use Stadline\LinkdataClient\src\Linkdata\Proxy\ProxyObject;

/**
 * @method ResponseInterface getActivity(string $id, array $options = [])
 * @method ResponseInterface getActivityDatastream(string $id, array $options = [])
 * @method ResponseInterface getActivityLocations(string $id, array $options = [])
 * @method ResponseInterface getActivities(array $options = [])
 * @method ResponseInterface putActivity(string $id, array $options = [])
 * @method ResponseInterface postActivity(array $options = [])
 * @method ResponseInterface deleteActivity(string $id, array $options = [])
 * @method ResponseInterface getActivityCalculation(string $id, array $options = [])
 * @method ResponseInterface getActivityCalculations(array $options = [])
 * @method ResponseInterface getBrand(string $id, array $options = [])
 * @method ResponseInterface getBrands(array $options = [])
 * @method ResponseInterface getConnector(string $id, array $options = [])
 * @method ResponseInterface getConnectors(array $options = [])
 * @method ResponseInterface getDatatype(string $id, array $options = [])
 * @method ResponseInterface getDatatypes(array $options = [])
 * @method ResponseInterface getDeviceModel(string $id, array $options = [])
 * @method ResponseInterface getDeviceModels(array $options = [])
 * @method ResponseInterface getDeviceNotification(string $id, array $options = [])
 * @method ResponseInterface getDeviceNotifications(array $options = [])
 * @method ResponseInterface putDeviceNotification(string $id, array $options = [])
 * @method ResponseInterface postDeviceNotification(string $id, array $options = [])
 * @method ResponseInterface deleteDeviceNotification(string $id, array $options = [])
 * @method ResponseInterface getFirmware(string $id, array $options = [])
 * @method ResponseInterface getFirmwares(array $options = [])
 * @method ResponseInterface getGlobalChallenge(string $id, array $options = [])
 * @method ResponseInterface getGlobalChallenges(array $options = [])
 * @method ResponseInterface getJob(string $id, array $options = [])
 * @method ResponseInterface getJobs(array $options = [])
 * @method ResponseInterface putJob(string $id, array $options = [])
 * @method ResponseInterface getUser(string $id, array $options = [])
 * @method ResponseInterface getUsers(array $options = [])
 * @method ResponseInterface getUserStat(string $id, array $options = [])
 * @method ResponseInterface putUser(string $id, array $options = [])
 * @method ResponseInterface postUser(string $id, array $options = [])
 * @method ResponseInterface deleteUser(string $id, array $options = [])
 * @method ResponseInterface getPoiCategory(string $id, array $options = [])
 * @method ResponseInterface getPoiCategories(array $options = [])
 * @method ResponseInterface getShareActivity(string $id, array $options = [])
 * @method ResponseInterface getShareActivities(array $options = [])
 * @method ResponseInterface postShareActivity(string $id, array $options = [])
 * @method ResponseInterface deleteShareActivity(string $id, array $options = [])
 * @method ResponseInterface getShareUser(string $id, array $options = [])
 * @method ResponseInterface getShareUsers(array $options = [])
 * @method ResponseInterface getShareUserStat(string $id, array $options = [])
 * @method ResponseInterface postShareUser(string $id, array $options = [])
 * @method ResponseInterface deleteShareUser(string $id, array $options = [])
 * @method ResponseInterface getSport(string $id, array $options = [])
 * @method ResponseInterface getSports(array $options = [])
 * @method ResponseInterface getStorageKey(string $id, array $options = [])
 * @method ResponseInterface getStorageKeys(array $options = [])
 * @method ResponseInterface getUniverse(string $id, array $options = [])
 * @method ResponseInterface getUniverses(array $options = [])
 * @method ResponseInterface getUserAgreement(string $id, array $options = [])
 * @method ResponseInterface getUserAgreements(array $options = [])
 * @method ResponseInterface putUserAgreement(string $id, array $options = [])
 * @method ResponseInterface postUserAgreement(string $id, array $options = [])
 * @method ResponseInterface getUserDevice(string $id, array $options = [])
 * @method ResponseInterface getUserDevices(array $options = [])
 * @method ResponseInterface putUserDevices(string $id, array $options = [])
 * @method ResponseInterface postUserDevices(string $id, array $options = [])
 * @method ResponseInterface deleteUserDevices(string $id, array $options = [])
 * @method ResponseInterface getUserMeasureGoal(string $id, array $options = [])
 * @method ResponseInterface getUserMeasureGoals(array $options = [])
 * @method ResponseInterface putUserMeasureGoal(string $id, array $options = [])
 * @method ResponseInterface postUserMeasureGoal(string $id, array $options = [])
 * @method ResponseInterface deleteUserMeasureGoal(string $id, array $options = [])
 * @method ResponseInterface getUserMeasure(string $id, array $options = [])
 * @method ResponseInterface getUserMeasures(array $options = [])
 * @method ResponseInterface putUserMeasure(string $id, array $options = [])
 * @method ResponseInterface postUserMeasure(string $id, array $options = [])
 * @method ResponseInterface deleteUserMeasure(string $id, array $options = [])
 * @method ResponseInterface getUserPoi(string $id, array $options = [])
 * @method ResponseInterface getUserpois(array $options = [])
 * @method ResponseInterface putUserPoi(string $id, array $options = [])
 * @method ResponseInterface postUserPoi(string $id, array $options = [])
 * @method ResponseInterface deleteUserPoi(string $id, array $options = [])
 * @method ResponseInterface getUserProgram(string $id, array $options = [])
 * @method ResponseInterface getUserPrograms(array $options = [])
 * @method ResponseInterface putUserProgram(string $id, array $options = [])
 * @method ResponseInterface postUserProgram(string $id, array $options = [])
 * @method ResponseInterface deleteUserProgram(string $id, array $options = [])
 * @method ResponseInterface getUserRecord(string $id, array $options = [])
 * @method ResponseInterface getUserRecords(array $options = [])
 * @method ResponseInterface getUserRoute(string $id, array $options = [])
 * @method ResponseInterface getUserRoutes(array $options = [])
 * @method ResponseInterface putUserRoute(string $id, array $options = [])
 * @method ResponseInterface postUserRoute(string $id, array $options = [])
 * @method ResponseInterface deleteUserRoute(string $id, array $options = [])
 * @method ResponseInterface getUserSession(string $id, array $options = [])
 * @method ResponseInterface getUserSessions(array $options = [])
 * @method ResponseInterface putUserSession(string $id, array $options = [])
 * @method ResponseInterface postUserSession(string $id, array $options = [])
 * @method ResponseInterface deleteUserSession(string $id, array $options = [])
 * @method ResponseInterface getUserStorage(string $id, array $options = [])
 * @method ResponseInterface getUserStorages(array $options = [])
 * @method ResponseInterface putUserStorage(string $id, array $options = [])
 * @method ResponseInterface postUserStorage(string $id, array $options = [])
 * @method ResponseInterface deleteUserStorage(string $id, array $options = [])
 * @method ResponseInterface getUserSumup(string $id, array $options = [])
 * @method ResponseInterface getUserSumups(array $options = [])
 */
class LinkdataClient extends HydraClient
{
    public function get(string $id): ProxyObject
    {
        $proxyManager = new ProxyManager();

        return $proxyManager->get($id, $this);
    }

    /**
     * @throws ClientHydraException
     */
    public function __call(string $method, array $args)
    {
        return $this->send($method, $args);
    }
}
