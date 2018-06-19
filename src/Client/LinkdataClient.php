<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Client;

use Stadline\LinkdataClient\src\Exception\LinkdataClientException;
use Stadline\LinkdataClient\src\Exception\RequestManagerException;
use Stadline\LinkdataClient\src\Utils\GuzzleRequester;
use Psr\Http\Message\ResponseInterface;
use Stadline\LinkdataClient\src\Utils\Serializator;
use Stadline\LinkdataClient\src\Utils\UriConverter;

/**
 * @method ResponseInterface getActivity(int $id, array $options = [])
 * @method ResponseInterface getActivityDatastream(int $id, array $options = [])
 * @method ResponseInterface getActivityLocations(int $id, array $options = [])
 * @method ResponseInterface getActivities(array $options = [])
 * @method ResponseInterface putActivity(int $id, array $options = [])
 * @method ResponseInterface postActivity(array $options = [])
 * @method ResponseInterface deleteActivity(int $id, array $options = [])
 *
 * @method ResponseInterface getActivityCalculation(int $id, array $options = [])
 * @method ResponseInterface getActivityCalculations(array $options = [])
 *
 * @method ResponseInterface getBrand(int $id, array $options = [])
 * @method ResponseInterface getBrands(array $options = [])
 *
 * @method ResponseInterface getConnector(int $id, array $options = [])
 * @method ResponseInterface getConnectors(array $options = [])
 *
 * @method ResponseInterface getDatatype(int $id, array $options = [])
 * @method ResponseInterface getDatatypes(array $options = [])
 *
 * @method ResponseInterface getDeviceModel(int $id, array $options = [])
 * @method ResponseInterface getDeviceModels(array $options = [])
 *
 * @method ResponseInterface getDeviceNotification(int $id, array $options = [])
 * @method ResponseInterface getDeviceNotifications(array $options = [])
 * @method ResponseInterface putDeviceNotification(int $id, array $options = [])
 * @method ResponseInterface postDeviceNotification(int $id, array $options = [])
 * @method ResponseInterface deleteDeviceNotification(int $id, array $options = [])
 *
 * @method ResponseInterface getFirmware(int $id, array $options = [])
 * @method ResponseInterface getFirmwares(array $options = [])
 *
 * @method ResponseInterface getGlobalChallenge(int $id, array $options = [])
 * @method ResponseInterface getGlobalChallenges(array $options = [])
 *
 * @method ResponseInterface getJob(int $id, array $options = [])
 * @method ResponseInterface getJobs(array $options = [])
 * @method ResponseInterface putJob(int $id, array $options = [])
 *
 * @method ResponseInterface getUser(int $id, array $options = [])
 * @method ResponseInterface getUsers(array $options = [])
 * @method ResponseInterface getUserStat(int $id, array $options = [])
 * @method ResponseInterface putUser(int $id, array $options = [])
 * @method ResponseInterface postUser(int $id, array $options = [])
 * @method ResponseInterface deleteUser(int $id, array $options = [])
 *
 * @method ResponseInterface getPoiCategory(int $id, array $options = [])
 * @method ResponseInterface getPoiCategories(array $options = [])
 *
 * @method ResponseInterface getShareActivity(int $id, array $options = [])
 * @method ResponseInterface getShareActivities(array $options = [])
 * @method ResponseInterface postShareActivity(int $id, array $options = [])
 * @method ResponseInterface deleteShareActivity(int $id, array $options = [])
 *
 * @method ResponseInterface getShareUser(int $id, array $options = [])
 * @method ResponseInterface getShareUsers(array $options = [])
 * @method ResponseInterface getShareUserStat(int $id, array $options = [])
 * @method ResponseInterface postShareUser(int $id, array $options = [])
 * @method ResponseInterface deleteShareUser(int $id, array $options = [])
 *
 * @method ResponseInterface getSport(int $id, array $options = [])
 * @method ResponseInterface getSports(array $options = [])
 *
 * @method ResponseInterface getStorageKey(int $id, array $options = [])
 * @method ResponseInterface getStorageKeys(array $options = [])
 *
 * @method ResponseInterface getUniverse(int $id, array $options = [])
 * @method ResponseInterface getUniverses(array $options = [])
 *
 * @method ResponseInterface getUserAgreement(int $id, array $options = [])
 * @method ResponseInterface getUserAgreements(array $options = [])
 * @method ResponseInterface putUserAgreement(int $id, array $options = [])
 * @method ResponseInterface postUserAgreement(int $id, array $options = [])
 *
 * @method ResponseInterface getUserDevice(int $id, array $options = [])
 * @method ResponseInterface getUserDevices(array $options = [])
 * @method ResponseInterface putUserDevices(int $id, array $options = [])
 * @method ResponseInterface postUserDevices(int $id, array $options = [])
 * @method ResponseInterface deleteUserDevices(int $id, array $options = [])
 *
 * @method ResponseInterface getUserMeasureGoal(int $id, array $options = [])
 * @method ResponseInterface getUserMeasureGoals(array $options = [])
 * @method ResponseInterface putUserMeasureGoal(int $id, array $options = [])
 * @method ResponseInterface postUserMeasureGoal(int $id, array $options = [])
 * @method ResponseInterface deleteUserMeasureGoal(int $id, array $options = [])
 *
 * @method ResponseInterface getUserMeasure(int $id, array $options = [])
 * @method ResponseInterface getUserMeasures(array $options = [])
 * @method ResponseInterface putUserMeasure(int $id, array $options = [])
 * @method ResponseInterface postUserMeasure(int $id, array $options = [])
 * @method ResponseInterface deleteUserMeasure(int $id, array $options = [])
 *
 * @method ResponseInterface getUserPoi(int $id, array $options = [])
 * @method ResponseInterface getUserpois(array $options = [])
 * @method ResponseInterface putUserPoi(int $id, array $options = [])
 * @method ResponseInterface postUserPoi(int $id, array $options = [])
 * @method ResponseInterface deleteUserPoi(int $id, array $options = [])
 *
 * @method ResponseInterface getUserProgram(int $id, array $options = [])
 * @method ResponseInterface getUserPrograms(array $options = [])
 * @method ResponseInterface putUserProgram(int $id, array $options = [])
 * @method ResponseInterface postUserProgram(int $id, array $options = [])
 * @method ResponseInterface deleteUserProgram(int $id, array $options = [])
 *
 * @method ResponseInterface getUserRecord(int $id, array $options = [])
 * @method ResponseInterface getUserRecords(array $options = [])
 *
 * @method ResponseInterface getUserRoute(int $id, array $options = [])
 * @method ResponseInterface getUserRoutes(array $options = [])
 * @method ResponseInterface putUserRoute(int $id, array $options = [])
 * @method ResponseInterface postUserRoute(int $id, array $options = [])
 * @method ResponseInterface deleteUserRoute(int $id, array $options = [])
 *
 * @method ResponseInterface getUserSession(int $id, array $options = [])
 * @method ResponseInterface getUserSessions(array $options = [])
 * @method ResponseInterface putUserSession(int $id, array $options = [])
 * @method ResponseInterface postUserSession(int $id, array $options = [])
 * @method ResponseInterface deleteUserSession(int $id, array $options = [])
 *
 * @method ResponseInterface getUserStorage(int $id, array $options = [])
 * @method ResponseInterface getUserStorages(array $options = [])
 * @method ResponseInterface putUserStorage(int $id, array $options = [])
 * @method ResponseInterface postUserStorage(int $id, array $options = [])
 * @method ResponseInterface deleteUserStorage(int $id, array $options = [])
 *
 * @method ResponseInterface getUserSumup(int $id, array $options = [])
 * @method ResponseInterface getUserSumups(array $options = [])
 */
class LinkdataClient
{
    /**
     * @throws LinkdataClientException
     */
    public function __call(string $method, array $args)
    {
        $uriConverter = new UriConverter();
        $uri = $uriConverter->formateUri($method, $args);
        $serializator = new Serializator();

        try {
            $requester = new GuzzleRequester();

            // Put or POST, make a serialization with the entity.
            if (in_array($uri['method'], ['post', 'put']) && count($args[0]) > 0) {
                $body = $serializator->serialize($args[0][0]);
                var_dump($body); die;
            }

            $response = $requester->makeRequest($uri['method'], $uri['uri'], $body);

            // Deserialize and return response.
            return $serializator->deserialize($response);
        } catch (RequestManagerException $e) {
            throw new LinkdataClientException(\sprintf('Error during call url : %s with %s method', $uri['method'], $uri['uri']));
        }
    }
}
