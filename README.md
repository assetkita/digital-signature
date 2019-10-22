# Asset Kita Digital Signature

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Contributor Covenant][ico-code-of-conduct]](CODE_OF_CONDUCT.md)

_Laravel digital signature package for Asset Kita._


## Requirements

- [Laravel v5.5.*](https://laravel.com)
- [Privy v3.0.0](https://privy.id) 


## Install

Require this package with composer using the following command:

```bash
composer require assetkita/digital-signature
```


## Configuration

This package needs some configuration to utilizing digital signature
service. Add these lines to your .env, then update respective values
based on your preferences.

```dotenv
DIGITAL_SIGNATURE_DRIVER=

PRIVY_MERCHANT_KEY=
PRIVY_USERNAME=
PRIVY_PASSWORD=
PRIVY_ENDPOINT_DEVELOPMENT=
PRIVY_ENDPOINT_PRODUCTION=
PRIVY_ENTERPRISE_TOKEN_DEVELOPMENT=
PRIVY_ENTERPRISE_TOKEN_PRODUCTION=
PRIVY_WEB_SDK_ENDPOINT_DEVELOPMENT=
PRIVY_WEB_SDK_ENDPOINT_PRODUCTION=
```

Publish package configuration via command:

```bash
php artisan vendor:publish --provider="Assetku\DigitalSignature\Providers\DigitalSignatureServiceProvider" --tag=config
```


## Digital Signature Facade

This package offers features to manage digital signature transactions
along with helpful facade `DigitalSignature`.
 
### Register

Use it with syntax `DigitalSignature::register($data)`.

Provide an array of data of user for registration process. The provided
array must comply the selected digital signature's rule. Here is the
following rule of registration for each driver:

```php
// privy
return [
    'email'                  => 'required|email',
    'phone'                  => 'required|string',
    'selfie'                 => 'required|image|mimes:png,jpg,jpeg|max:2048',
    'ktp'                    => 'required|image|mimes:png,jpg,jpeg|max:2048',
    'identity'               => 'required|array',
    'identity.nik'           => [
        'required',
        'numeric',
        'digits:16',
        'regex:/[1-9]$/' // the last digit must not equals to 0
    ],
    'identity.name'          => 'required|string|min:3',
    'identity.tanggal_lahir' => 'required|date'
];
```

The registration process will throws exceptions as follows:
- GuzzleException
- DigitalSignatureValidatorException (has errors attribute)
- DigitalSignatureRegistrationException (has errors attribute)

The return of registration process is instance of abstract class
`\Assetku\DigitalSignature\Users\User` according to selected driver.
Here is the following user instance for each driver:

```php
// privy
new \Assetku\DigitalSignature\Users\Privy\PrivyUser;
```

### Check Registration Status

Use it with syntax `DigitalSignature::checkRegistrationStatus($token)`.

Provide a string of user token for check registration status process.
The provided token must comply the selected digital signature's rule.
Here is the following rule of check registration status for each driver:

```php
// privy
return [
    'token' => 'required|string'
];
```

The check registration status process will throws exceptions
as follows:
- GuzzleException
- DigitalSignatureValidatorException (has errors attribute)
- DigitalSignatureCheckRegistrationStatusException (has errors attribute)

The return of check document status process is instance of abstract
class `\Assetku\DigitalSignature\Users\User` according to selected
driver. Here is the following user instance for each driver:

```php
// privy
new \Assetku\DigitalSignature\Users\Privy\PrivyUser;
```

### Upload Document

Use it with syntax `DigitalSignature::uploadDocument($data)`.

Provide an array of data of user for upload document process. The
provided array must comply the selected digital signature's rule. Here
is the following rule of upload document for each driver:

```php
// privy
return [
    'documentTitle'                => 'required|string',
    'docType'                      => [
        'required',
        'string',
        function ($attribute, $value, $fail) {
            if (! $value === 'Serial' || ! $value === 'Parallel') {
                $fail("{$attribute} harus berupa Serial atau Parallel");
            }
        }
    ],
    'owner'                        => 'required|array',
    'owner.privyId'                => 'required|string',
    'owner.enterpriseToken'        => 'required|string',
    'document'                     => 'required|file|mimes:pdf|max:2048',
    'recipients'                   => 'required|array',
    'recipients.*.privyId'         => 'required|string',
    'recipients.*.type'            => [
        'required',
        'string',
        function ($attribute, $value, $fail) {
            if (! $value === 'Signer' || ! $value === 'Reviewer') {
                $fail("{$attribute} harus berupa Signer atau Reviewer");
            }
        }
    ],
    'recipients.*.enterpriseToken' => 'nullable|string'
];
```

The upload document process will throws exceptions as follows:
- GuzzleException
- DigitalSignatureValidatorException (has errors attribute)
- DigitalSignatureUploadDocumentException (has errors attribute)

The return of registration process is instance of abstract class
`\Assetku\DigitalSignature\Documents\Document` according to selected
driver. Here is the following document instance for each driver:

```php
// privy
new \Assetku\DigitalSignature\Documents\Privy\PrivyDocument;
```

### Check Document Status

Use it with syntax `DigitalSignature::checkDocumentStatus($token)`.

Provide a string of document token for check document status process.
The provided token must comply the selected digital signature's rule.
Here is the following rule of check document status for each driver:

```php
// privy
return [
    'docToken' => 'required|string'
];
```

The check document status process will throws exceptions as follows:
- GuzzleException
- DigitalSignatureValidatorException (has errors attribute)
- DigitalSignatureCheckDocumentStatusException (has errors attribute)

The return of check document status process is instance of abstract
class `\Assetku\DigitalSignature\Documents\Document` according to
selected driver. Here is the following document instance for each
driver:

```php
// privy
new \Assetku\DigitalSignature\Documents\Privy\PrivyDocument;
````

### Get Enterprise Token

Use it with syntax `DigitalSignature::getEnterpriseToken()`.

This is for upload document purpose. The return value is string type of enterprise token of selected driver.

### Get Web SDK Endpoint

Use it with syntax `DigitalSignature::getWebSDKEndpoint()`.

This is for view document purpose. The return value is string type of web SDK endpoint of selected driver.


## Digital Signature User

The digital signature user has the following attributes:
- id
- email
- phone
- token
- status
 
It has methods for checking registration's status:
- isStatusVerified()
- isStatusWaiting()
- isStatusRegistered()
- isStatusInvalid()
- isStatusRejected()


## Digital Signature Document

The digital signature user has the following attributes:
- token
- url
- recipients
 
It has methods for checking document's status:
- isStatusCompleted()
- isStatusInProgress()


## Digital Signature Document Recipient

The digital signature user has the following attributes:
- id
- role
- status
 
It has methods for checking document recipient's role & status:
- isRoleSigner()
- isRoleReviewer()
- isStatusCompleted()
- isStatusInProgress()


## Document View

This package comes with example document view for signing purpose. You
can publish it then apply some customizations to fulfill your needs.

Publish package views via command:

```bash
php artisan vendor:publish --provider="Assetku\DigitalSignature\Providers\DigitalSignatureServiceProvider" --tag=views
```

If you want to override the views don't forget to set the web SDK endpoint, document
token, user identification, & signature page number from laravel 
controller. After that place your callback in javascript for the
following events:
- after-action (after user has been signed or reviewed)
- after-sign (after user has been signed)
- after-review (after user has been reviewed)

Testing

The tests are written with `phpunit`. You can run the tests from the root of the project directory with the following command.

```bash
vendor/bin/phpunit
```


## License

The Digital Signature package is open source software licensed under the
[GNU LGPL license version 3](https://opensource.org/licenses/LGPL-3.0)

[ico-version]: https://img.shields.io/packagist/v/assetkita/digital-signature.svg?style=flat-square
[ico-license]: https://img.shields.io/packagist/l/assetkita/digital-signature.svg?style=flat-square
[ico-code-of-conduct]: https://img.shields.io/badge/Contributor%20Covenant-v1.4%20adopted-ff69b4.svg
[link-packagist]: https://packagist.org/packages/assetkita/digital-signature
