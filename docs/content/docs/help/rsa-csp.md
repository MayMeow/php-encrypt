---
title: "RSA Crypto service provider"
description: "RSA CPS is used for creating asymetric ciphers."
lead: "RSA CPS is used for creating asymetric ciphers."
date: 2021-01-23T14:42:26+01:00
lastmod: 2021-01-23T14:42:26+01:00
draft: false
images: []
menu:
  docs:
    parent: "help"
weight: 202
toc: true
---

RSACSP is replace Security factory. It's used for asymetric encryption. Asymetric encryption is using two keys, public for encrypt and private key for decrypt data;

```php
// Generate keypPairs
use MayMeow\Cryptography\RSA\RSACryptoServiceProvider;
use MayMeow\Cryptography\Filesystem\RsaParametersFileLoader;

$this->csp = new RSACryptoServiceProvider();
```

## Keipair generate

```php
// generate new keypairs
$keypair = $this->csp->generateKeyPair('yourSuperStrongPas$$phrase'); // returns RSAParameter
```

or you can use loader to load Keypairs from files as following example. Yuo can create your own loaders by implementing `MayMeow\Cryptography\Filesystem\FileLoaderInterface`.

```php
// OR Load keypairs from file
$fileLoader = new RsaParametersFileLoader();
$this->csp->setRsaParameters($fileLoader->load('name_of_certificate'));
```

## Encrypt and decrypt

```php
// Ecrypt and decrypt
$plainText = 'Hello World!';
$encryptedText = $this->csp->encrypt($plainText);
$decrypted = $this->csp->decrypt($encryptedText);
```

## Signing and verifiing

Can be used to verifiy if signed data was changed or no.

```php
// Signing
$signature = $this->csp->sign($plainText);
$this->csp->verify($plainText, $signature); // true or false
```

## Generating fingerprint

```php
// md5 fingerprint
$this->csp->getFingerPrint();
```
