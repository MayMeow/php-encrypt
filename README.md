# PHP Encrypt

[![Beerpay](https://beerpay.io/MayMeow/php-encrypt/badge.svg)](https://beerpay.io/MayMeow/php-encrypt)
[![Build Status](https://travis-ci.org/MayMeow/php-encrypt.svg?branch=master)](https://travis-ci.org/MayMeow/php-encrypt)

Library for signing certificates with selfsigned CA known as May-Encrypt

## Installation

Install with docker:
```bash
composer require maymeow/php-encrypt
```

And intialize it withhin your script
```php
$cf = new \MayMeow\Factory\CertificateFactory(new \MayMeow\Model\EncryptConfiguration());
```

## Usage

### Path Configuring

To Set different Root path for generated certificates use

```php
$cf->setDataPath('/your/path/to/folder');
```

If you want to save templates for generating certificates on different folder you can set this path with:

```php
$cf->setTemplatesPath('/path/to/templates/folder');
```

To chanage folder to change path to your configuration file

```php
$cf->setConfigPath('/path/to/templates/folder/my_config_file.yml');
```

If you don use any of this commands default values will be used.

### Certificate Signing

1. Create Selfsigned CA

```php
$cf->domainName()
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setCountryName('SK')
    ->setCommonName('Hogwarts School of Witchcraft and Wizardry Root CA');

$cf->setType('ca')
    ->setName('Hogwarts')
    ->sign()->toFile();
```

2. Create Intermediate CAs. This type of CA you will use for signing users and servers certificates.

```php
$cf->domainName()
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setCountryName('SK')
    ->setOrganizationalUnitName('Hogwarts houses')
    ->setCommonName('Slytherin HSoWaW House');

$cf->setType('intermediate')
    ->setName('Hogwarts/Slytherin')
    ->setCa('Hogwarts', '200634')
    ->sign()->toFile();
```

3. Sign User or server certificate

* User Certificate

```php
$cf->domainName()
    ->setCommonName('Hermione Granger')
    ->setEmailAddress('hermione.granger@g.hogwarts.local')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setOrganizationalUnitName('Hogwarts Students');

$cf->setType('user')
    ->setName('Hogwarts/Students/hermione-granger')
    ->setCa('Hogwarts/Gryffindor', '296545')
    ->sign()->toFile(true);
```

* Server Certificate

```php
$cf->domainName()
    ->setCommonName("gryffindor.hogwarts.local")
    ->setOrganizationalUnitName("Hogwarts Webpages")
    ->setOrganizationName("Hogwarts School of Witchcraft and Wizardry");

$cf->getAltNames()
    ->setDns("gryffindor.hogwarts.local")
    ->setDns("*.gryffindor.hogwarts.local")
    ->setIp("10.0.20.2");

$cf->setType("server")
    ->setName("Hogwarts/Webpages/griffindor-hogwarts-local")
    ->setCa('Hogwarts/Gryffindor', '296545')
    ->sign()->toFile();
```

4. Each certificatess are located in `webroot/<certificate-name>`. Certificate Names can be set
with `->setName(<certificate-name>)` function.
5. To load CA for signing certificate you will use `->setCa(<certificate-name>, <certificate-key-pass>)`.
__Certificate Key pass__ is located in `code.txt` file in each certificate folder.

### PKCS12 file format

Windows users need certificate in PKCS12 format, `.pfx` file extension. To create this type of file use

```php
...->toFile(true);
```

### Creating key pairs

If you dont need certificate you can create key pair `from v2018.4`

```php
$keys = $cf->setType('ca')->setName('keys-2')->getKeyPair(true); // true means keys will be stored into files

$keys->getPrivateKey(); // returns private key
$keys->getPublicKey(); // returns public key
```

### Loaders 

Loaders are new feature that can be used to load Key pair `from v2018.5`. Each loader implements LoaderInterfaace. To use them follow example below.

```php
// use CertificateFactory and generated keys
$kl = new \MayMeow\Loaders\KeyPairLoader($cf, $keys);

$kl->getPublicKey() // return string with public key
$kl->getPrivateKey() // return string with private key
```

When you have certificate or keypair generated to file you can use File loader

```php
$kl = new \MayMeow\Loaders\KeyPairFileLoader($cf, 'keys-2');

$kl->getPublicKey() // return string with public key
$kl->getPrivateKey() // return string with private key
```

## Security factory

Security factory can be used for encryptig and decripting strings.

1. Initialize security factory

```php
$sf = new \MayMeow\Factory\SecurityFactory($cf);
```

2. Set string which you want to encrypt

```php
$string = json_encode([
    "name" => 'Hello',
    "surname" => 'world'
]);
$sf->setString($string);
```

3. load keys that will be used to encrypt / decrypt

```php
$sf->setPrivateKey('keys-2', null);
$sf->setPublicKey('keys-2');
```

or you can use loaders to set keypairs

```php
$sf->setKeyPair(new KeyPairFileLoader('keys-2'));
```

5. Encrypt text

```php
$enc = base64_encode($sf->publicEncrypt());
```

6. Decrypt

```php
$sf->setString(base64_decode($enc));
$decrypted = base64_encode($sf->privateDecrypt());
```

Example above will encrypt text with public key and decrypt with private. If you want encrypt with private just use `$sf->encrypt()` and `$sf->decrypt` for decrypting.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

SEE changelog

## Credits

* MayMeow
* mARTin

## License

MIT

## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/MayMeow/may-encrypt/badge.svg?style=beer-square)](https://beerpay.io/MayMeow/may-encrypt)  [![Beerpay](https://beerpay.io/MayMeow/may-encrypt/make-wish.svg?style=flat-square)](https://beerpay.io/MayMeow/may-encrypt?focus=wish)
## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/MayMeow/php-encrypt/badge.svg?style=beer-square)](https://beerpay.io/MayMeow/php-encrypt)  [![Beerpay](https://beerpay.io/MayMeow/php-encrypt/make-wish.svg?style=flat-square)](https://beerpay.io/MayMeow/php-encrypt?focus=wish)