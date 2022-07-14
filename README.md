# Printformer PHP SDK
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Latest Stable Version](https://poser.pugx.org/risscsolutions/printformer-php-sdk/v/stable.svg)](https://packagist.org/packages/risscsolutions/printformer-php-sdk)
[![Total Downloads](https://poser.pugx.org/risscsolutions/printformer-php-sdk/downloads)](https://packagist.org/packages/risscsolutions/printformer-php-sdk)
[![GitHub Workflow Status (event)](https://img.shields.io/github/workflow/status/risscsolutions/printformer-php-sdk/PHPUnit%20tests?event=push&label=PHPUnit%20tests)](https://github.com/risscsolutions/printformer-php-sdk/actions/workflows/tests.yml)
[![GitHub Workflow Status (event)](https://img.shields.io/github/workflow/status/risscsolutions/printformer-php-sdk/Static%20code%20analysis?event=push&label=Static%20code%20analysis)](https://github.com/risscsolutions/printformer-php-sdk/actions/workflows/static%20code%20analysis.yml)

### [Documentation](https://risscsolutions.github.io/printformer-php-sdk/)

## Installation

```bash
composer require risscsolutions/printformer-php-sdk
```

## Usage

### Create a new Instance of the printformer-SDK
```php
use Rissc\Printformer;

$config = [
    'base_uri' => 'YOUR printformer URL',
    'identifier' => 'YOUR TENANT IDENTIFIER',
    'api_key' => 'YOUR TENANT API KEY',
];

$printformer = new Printformer($config);
```

### Create a new User
```php
$pfUser = $this->printformer->clientFactory()->user()->create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'locale' => 'en',
    'email' => 'john.doe@rissc.com', 
]);
```

### Create a new Draft
by passing an array to the DraftClient
```php
$draftClient = $printformer->clientFactory()->draft();
$draft = $draftClient
    ->create([
        'templateIdentifier' => 'YOUR MASTER TEMPLATE IDENTIFIER',
        'user_identifier' => $pfUser->getIdentifier(),
        'intent' => 'customize'
    ]);
```
or with a fluid builder
```php
$draftBuilder = $printformer->builderFactory()->draft();
$draft = $draftBuilder
    ->template('YOUR MASTER TEMPLATE IDENTIFIER')
    ->user($pfUser->getIdentifier())
    ->intent('customize')
    ->create();
```

### Create a URL to the Editor
```php
$url = (string)$printformer->urlGenerator()->editor()
        ->draft($draft->getIdentifier())
        ->callback('https://YOUR-CALLBACK-URL-HERE')
        ->callbackCancel('https://YOUR-CANCEL-CALLBACK-URL-HERE') // Optional, if omitted the callback URL is used
        ->callbackHalt('https://YOUR-HALT-CALLBACK-URL-HERE') // Optional, if omitted the callbackCancel URL is used
        ->user($pfUser->getIdentifier())
        ->step('preview') // Optional, if omitted the editor jumps to the last visited step
```

### Create a Print PDF
```php
$printformer->clientFactory()->processing()->create(
    [$draft->getIdentifier(), $otherDraft->getIdentifier()],
    'https://YOUR-CALLBACK-URL-HERE'
);
```

### Create a URL to the Print PDF
```php
(string)$printformer->urlGenerator()
->draftFiles()
->printFile($draft->getIdentifier())
->expiresAt((new \DateTimeImmutable())->modify('+1 hour'))
```

### Replicate a draft
```php
$draftClient = $printformer->clientFactory()->draft();
$draft = $draftClient
    ->replicate($draft, []);
```
