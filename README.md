# OneSkyBundle
[![Build Status](https://travis-ci.org/OpenClassrooms/OneSkyBundle.svg?branch=master)](https://travis-ci.org/OpenClassrooms/OneSkyBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/87d6eebd-6344-4e30-86a6-71e501a2aa8b/mini.png)](https://insight.sensiolabs.com/projects/87d6eebd-6344-4e30-86a6-71e501a2aa8b)
[![Coverage Status](https://coveralls.io/repos/github/OpenClassrooms/OneSkyBundle/badge.svg?branch=master)](https://coveralls.io/github/OpenClassrooms/OneSkyBundle?branch=master)

The OneSkyBundle offers integration of the [OneSky Client](https://github.com/onesky/api-library-php5) for common tasks like pulling and pushing translations.
[OneSky](https://www.oneskyapp.com/) is a plateform that provides translations management.

## Installation
This bundle can be installed using composer:

```composer require openclassrooms/onesky-bundle```

or by adding the package to the composer.json file directly:

```json
{
    "require": {
        "openclassrooms/onesky-bundle": "*"
    }
}
```

After the package has been installed, add the bundle to the AppKernel.php file:
```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new OpenClassrooms\Bundle\OneSkyBundle\OpenClassroomsOneSkyBundle(),
    // ...
);
```

## Configuration
```yml
# app/config/config.yml

openclassrooms_onesky:
    api_key:  %onesky.api_key%
    api_secret: %onesky.api_secret%
    project_id: %onesky.project_id%
    source_locale: %source_locale% #optional, default en
    locales:
      - fr
      - es
    file_format: %onesky.file_format% #optional, default xliff
    file_paths:
      - %path.to.translations.files.directory%
    
```

## Usage
### Pull
```php
$commentBuilder = $container->get('openclassrooms.akismet.models.comment_builder');
$akismet = $container->get('openclassrooms.akismet.services.default_akismet_service');

$comment = $commentBuilder->create()
                          ...
                          ->build();
               
if ($akismet->commentCheck($comment)) {
 // store the comment and mark it as spam (in case of a mis-diagnosis).
} else {
 // store the comment normally
}

// and

$akismet->submitSpam($comment);

// and

$akismet->submitHam($comment);
```

### Bridge Service
The Bundle integrates a bridge service which gets the Symfony2 requestStack to automatically set the UserIP, UserAgent and Referrer.
```xml
<service id="openclassrooms.akismet.services.akismet_service" class="OpenClassrooms\Bundle\AkismetBundle\Services\Impl\AkismetServiceImpl">
    <call method="setAkismet">
        <argument type="service" id="openclassrooms.akismet.services.default_akismet_service"/>
    </call>
    <call method="setRequestStack">
        <argument type="service" id="request_stack"/>
    </call>
</service>
```

You can use it by getting this service id:
```php
$akismet = $container->get('openclassrooms.akismet.services.akismet_service');

```
instead of:
```php
$akismet = $container->get('openclassrooms.akismet.services.default_akismet_service');

```
