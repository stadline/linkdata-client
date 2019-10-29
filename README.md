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
    "repositories": {
        {
            "type": "vcs",
            "url": "https://github.com/stadline/linkdata-client.git"
        }
    }
}
```

And run : 
```bash
composer require stadline/sporttrackindatasdk
```

### Symfony installation 

This project is published with a symfony bundle for a quick integration in your own symfony application.

Add this configuration : 
```yaml
parameters: 
    sporttrackingdata.base_url: 'http://35.159.15.229/'
    sporttrackingdata.entity_namespace: 'Stadline\LinkdataClient\Linkdata\Entity'
    sporttrackingdata.iri_prefix: '/v2'

sport_tracking_data_sdk:
    base_url: '%sporttrackingdata.base_url%'
    entity_namespace: '%sporttrackingdata.entity_namespace%'
    iri_prefix: '%sporttrackingdata.iri_prefix%'
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
