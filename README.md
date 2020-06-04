Warning : This library is a public preview for the SDK. Changes can be applied in the next weeks. 

## Synopsis

This library provide a PHP SDK for SportTracking API.  

## Installation

On your composer.json add the following : 
```json
{
    "require": {
        "stadline/linkdata-client": "2.0.x-dev"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/stadline/linkdata-client.git"
        }
    ]
}
```

And run : 
```bash
composer require stadline/sporttrackindatasdk
```
### Standalone installation

To use this project without any framework you can simply use the following code : 

```$xslt
$stdClient = new SportTrackingDataClient('https://linkdata.dev.geonaute.com');
$stdClient->setAuthorizationToken('eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJhY2NvdW50LmRldi5nZW9uYXV0ZS5jb20iLCJleHAiOjE2NTc0MTQ1NzYsImlhdCI6MTU1NzQxMDk3NiwibGRpZCI6IjIzZTExNTIzNDU4OGQyYTE2M2U3Iiwic3RhY2siOiJldTEiLCJmaXJzdG5hbWUiOiJDaGFybGVzIiwibGFzdG5hbWUiOiJBTlNTRU5TIiwiZW1haWwiOiJjYW5zc2Vuc0BnbWFpbC5jb20iLCJnZW5kZXIiOiJGZW1hbGUiLCJiaXJ0aGRhdGUiOiIxOTkwLTAxLTAyIiwiY291bnRyeSI6IlROIiwic3ViIjoiMjYwMTA2NTg1NzUiLCJsb2dpbl9kZWNhdGhsb24iOiJjYW5zc2Vuc0BnbWFpbC5jb20iLCJtaWdyYXRlZCI6dHJ1ZX0.SZSXAxVNZbDX1aI-gQuRMmkLtAGnLhUOaaCwD4F0pOqvaUz84mdCHd-OB_t69zxPN6r8tT1fQMkzcsGvc4gscO0h45Euq_JRJTeM9V1FYfP0ippov3nEcEaFzXANt7RL7NrNR-qTVLg4UJdCp6uAs6Dqf__MreXbDnIiPO15pdjpR2vGrvd3cEOSxIyD5qBAKSXRJk_KLkSTiz6G8n4eIpPTHMGhJjxrqshWztRnuM7GOGp4vQkFU5mPYVlhqrY-n576xZO2VBkbI3sF6aYx4mvdeHsLzVw2woInRY09eZHFwHynE13rAKOlTM66IYgKeI3Yn0Id3SZkOP_tnNZBnWjW0YTDlpRqeq5oMpE0AK-yXG4-UQ85e3q9KViq0Tf47LtqFhQKwbfrRM6D0AGUOQGilL2GJ2ETLHcYE9O3TRVSeMnCYvxyTlGd0XVVo3F_fUY9EcnUMiMAsiBJYKZFCis7BrQjpEiqAVvL_lUAzeLrrh5zos6KpnzzMyFsD9dJdobjX8cNLPAtpGiFgTwRCSLZUsa-4Bl3xfwpfYl_h5LqoZqlYqv57Wd-UXXYxDEy11UZJE4QxxIS0mcwstZJGweTkGudM30Y4XjN2equokWCLFzqnR7Z6kweiBvqxbMS6I6XqBe1o62Pt7mHwWZlAYFw-3jQS2U1ROmXZ6G4SEA');

```

[Click here](examples/standalone/example1.php) to see a complete example of standalone usage.

### Symfony installation 

This project is published with a symfony bundle for a quick integration in your own symfony application.

Add this configuration : 
```yaml
parameters: 
    sporttrackingdata_sdk.base_url: 'https://linkdata.geonaute.com/'
    sporttrackingdata_sdk.entity_namespace: 'SportTrackingDataSdk\SportTrackingData\Entity'
    sporttrackingdata_sdk.iri_prefix: '/v2'

sport_tracking_data_sdk:
    base_url: '%sporttrackingdata_sdk.base_url%'
    entity_namespace: '%sporttrackingdata_sdk.entity_namespace%'
    iri_prefix: '%sporttrackingdata_sdk.iri_prefix%'
```

Add this to your Kernel declaration : 
```
new SportTrackingDataSdk\SportTrackingData\Bridge\Symfony\Bundle\SportTrackingDataSdkBundle()
```


## Usage

To interact with the API you must inject `SportTrackingDataSdk\SportTrackingData\Client\SportTrackingDataClient` (or use service name : `sporttrackingdata_sdk.client`) to your Symfony service / controller.

The directory `SportTrackinData/Entity` contains all the entities you can get with the api.

### Get Collection 

To get a list of entities you must call :

```
    $entities = $client->getCollection(Sport::class, ['active' => true]);
```

`getCollection` first parameter is entity's classname and second is filters to apply.
It returns a `ProxyCollection` : an iterable object (collection of `ProxyObject`) which dynamically get new objects when you want to access to it.

Warning : If you call `count` method on ProxyCollection, it will get all the pages from the API.

If you want to disable auto hydratation, you can use : `setAutoHydrateEnable(false)`

### Get Entity

To get an entity you must call :

```php
    $object = $client->getObject(Sport::class, 121);
```

It returns a `ProxyObject` : an iterable object which dynamically related objects when you want to access to it.

### Post Entity

To add an entity you must call :

```php
    $object = new Sport();
    $object->setName("My awesome name");
    
    $client->postObject($object);
```

For the entity relations, you can set the entity object, id or iri. 

Example : 
```php
    $object = new Activity();
    $object->setUser("/v2/users/1234");
    // or 
    $object->setUser($this->getObject(User::class, 1234));
    // or 
    $object->setUser(1234);
```

### Put Entity

To edit an entity you must call :

```php
    $object = $client->getObject(Sport::class, 121);
    
    $object->setName("My awesome name");
    
    $client->putObject($object);
```

### Delete Entity

To delete an entity you must call :

```php
    $object = $client->getObject(Sport::class, 121);
    
    $client->deletedObject($object);
```

### Custom endpoints

The API contains a few custom methods, which not correspond to any Entity. For this case, you can use the methods of the `SportTrackingDataClient` :

Example : 

```php
    $statsArray = $client->getUserStatistics(12345); 
```
