# Printformer PHP SDK

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
```php
$draft = $printformer->clientFactory()->draft()->create([
    'templateIdentifier' => 'YOUR MASTER TEMPLATE IDENTIFIER',
    'user_identifier' => $pfUser->identifier,
    'intent' => 'customize'
]);
```

### Create a URL to the Editor
```php
$url = (string)$printformer->urlGenerator()->editor()
        ->draft($draft->draftHash)
        ->user($pfUser->identifier);
```

### Create a Print PDF
```php
$printformer->clientFactory()->processing()->create([
    'draftIds' => [$draft->draftHash],
]);
```

### Create a URL to the Print PDF
```php
(string)$printformer->urlGenerator()->draftFiles()->printFile($draft->draftHash);
```
