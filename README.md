# Printformer PHP SDK
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Latest Stable Version](https://poser.pugx.org/risscsolutions/printformer-php-sdk/v/stable.svg)](https://packagist.org/packages/risscsolutions/printformer-php-sdk)
[![Total Downloads](https://poser.pugx.org/risscsolutions/printformer-php-sdk/downloads)](https://packagist.org/packages/risscsolutions/printformer-php-sdk)
[![PHPunit Tests](https://github.com/risscsolutions/printformer-php-sdk/actions/workflows/tests.yml/badge.svg?branch=master&event=push)](https://github.com/risscsolutions/printformer-php-sdk/actions/workflows/tests.yml)
[![Psalm Static analysis](https://github.com/risscsolutions/printformer-php-sdk/actions/workflows/psalm.yml/badge.svg?branch=master&event=push)](https://github.com/risscsolutions/printformer-php-sdk/actions/workflows/psalm.yml)

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

$printformer new Printformer($config);
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
        'user_identifier' => $pfUser->identifier,
        'intent' => 'customize'
    ]);
```
or with a fluid builder
```php
$draftBuilder = $printformer->builderFactory()->draft();
$draft = $draftBuilder
    ->template('YOUR MASTER TEMPLATE IDENTIFIER')
    ->user($pfUser->identifier)
    ->intent('customize')
    ->create();
```

### Create a URL to the Editor
```php
$url = (string)$printformer->urlGenerator()->editor()
        ->draft($draft->draftHash, 'https://YOUR-CALLBACK-URL-HERE')
        ->user($pfUser->identifier);
```

### Create a Print PDF
```php
$printformer->clientFactory()->processing()->create(
    [$draft->draftHash, $otherDraft->draftHash],
    'https://YOUR-CALLBACK-URL-HERE'
);
```

### Create a URL to the Print PDF
```php
(string)$printformer->urlGenerator()
->draftFiles()
->printFile($draft->draftHash)
->expiresAt(new \DateTimeImmutable()->modify('+1 hour'))
```
