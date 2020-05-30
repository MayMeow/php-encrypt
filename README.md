# PHP Encrypt

Library for signing certificates with selfsigned CA

![](https://github.com/maymeow/php-encrypt/workflows/PHP%20Composer/badge.svg)

## Installation

Install with docker:
```bash
composer require maymeow/php-encrypt
```

And intialize it withhin your script
```php
$cf = new \MayMeow\Factory\CertificateFactory(new \MayMeow\Model\EncryptConfiguration());
```

## Usage [WIP]

### Path Configuring

To set diferent path for cert templates (cnf files) use:

```php
// dont forget to use trailing slash
$cf = new \MayMeow\Factory\CertificateFactory(new \MayMeow\Model\EncryptConfiguration(), '/path/to/templates/folder/');
```

To chanage folder to change path to your configuration file

```php
// use full path to your configuration file include name of this file
$cf = new \MayMeow\Factory\CertificateFactory(new \MayMeow\Model\EncryptConfiguration('/path/to/templates/folder/my_config_file.yml'));
```

### Certificate Signing

1. Create Selfsigned CA

```php
use MayMeow\Writers\FileWriter;

$cf->domainName()
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setCountryName('SK')
    ->setCommonName('Hogwarts School of Witchcraft and Wizardry Root CA');

$cf->setType('ca')
    ->setName('Hogwarts')
    ->sign()
    ->writeTo(FileWriter::class);
```

2. Create Intermediate CAs. This type of CA you will use for signing users and servers certificates.

```php
use MayMeow\Writers\FileWriter;
use MayMeow\Loaders\FileLoader;

$cf->domainName()
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setCountryName('SK')
    ->setOrganizationalUnitName('Hogwarts houses')
    ->setCommonName('Slytherin HSoWaW House');

$cf->setType('intermediate')
    ->setName('Hogwarts/Slytherin')
    ->setCaFrom(new FileLoader('test-ca'))
    ->sign()->writeTo(FileWriter::class);
```

3. Sign User or server certificate

* User Certificate

```php
use MayMeow\Writers\FileWriter;
use MayMeow\Loaders\FileLoader;

$cf->domainName()
    ->setCommonName('Hermione Granger')
    ->setEmailAddress('hermione.granger@g.hogwarts.local')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setOrganizationalUnitName('Hogwarts Students');

$cf->setType('user')
    ->setName('Hogwarts/Students/hermione-granger')
    ->setCaFrom(new FileLoader('test-ca'))
    ->sign()->writeTo(FileWriter::class);
```

* Server Certificate

```php
use MayMeow\Writers\FileWriter;
use MayMeow\Loaders\FileLoader;

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
    ->setCaFrom(new FileLoader('test-ca'))
    ->sign()->writeTo(FileWriter::class);
```

4. Each certificatess are located in `webroot/<certificate-name>`. Certificate Names can be set
with `->setName(<certificate-name>)` function.
5. To load CA for signing certificate you will use `->setCa(<certificate-name>, <certificate-key-pass>)`.
__Certificate Key pass__ is located in `code.txt` file in each certificate folder.

### PKCS12 file format

Windows users need certificate in PKCS12 format, `.pfx` file extension. To create this type of file use

```php
// public function write($decryptPK = false, $pcks12 = false);
...->write(false, true);
```

### Creating key pairs

If you dont need certificate you can create key pair `from v2018.4` updated in `v2019.5`

```php
use MayMeow\RSA\RSACryptoServiceProvider;

$this->csp = new RSACryptoServiceProvider();
$keypair = $this->csp->generateKeyPair('yourSuperStrongPas$$phrase'); // returns RSAParameters

// privateKey & public key
$keypair->getPrivateKey();
$keypair->getPublicKey();
```

### Loaders 

Loaders are new feature that can be used to load Key pair `from v2018.5` updated in `2020.6`. Each loader implements LoaderInterfaace. To use them follow example below. If you have protected (encrypted) private key **loaders are place where is decrypting based on passphrase**. **SecurityFactory using only decrpted private_keys**.

`v2020.6` will change using loaders. No more is required to use passphrase when you load certificate from file

```php
use MayMeow\Loaders\FileLoader;

$kp = new FileLoader('test-ca');
$kp->getPublicKey();
$kp->getPrivateKey();
```

## RSA Crypto Service Provider

RSACSP is replace Security factory. It's used for asymetric encryption. Asymetric encryption is using two keys, public for encrypt and private key for decrypt data;

```php
// Generate keypPairs
use MayMeow\RSA\RSACryptoServiceProvider;

$this->csp = new RSACryptoServiceProvider();
$keypair = $this->csp->generateKeyPair('yourSuperStrongPas$$phrase'); // returns RSAParameters

// Ecrypt and decrypt
$plainText = 'Hello World!';
$encryptedText = $this->csp->encrypt($plainText);
$decrypted = $this->csp->decrypt($encryptedText);

// Signing
$signature = $this->csp->sign($plainText);
$this->csp->verify($plainText, $signature); // true or false

// md5 fingerprint
$this->csp->getFingerPrint();
```

## AES Crypto Service Provider

AESCSP is using for aes encryption. Aes is symetric encryption, is using only one key for encrypt/decrypt data. For more security it can be used together with asymetric encryption.

```php
use MayMeow\Cryptography\AES\AESCryptoServiceProvider;

//initialize CSP, generate key and IV
$csp = new AESCryptoServiceProvider();
$csp->generateIV();
$key = $csp->generateKey();

//encrypt data
$plainText = "This is going to be encrypted!";
$encryptedText = $this->csp->encrypt($plainText);

// inistialize another CSP
// sure you can use same instance to decrypt but in most cases you only ancrypting
// and then storing to database to decrypt it later
$csp2 = new AESCryptoServiceProvider();
$csp2->setKey($key); // et key you generated before

//decrypt text
$originalText = $csp2->decrypt($encryptedText);
```

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

SEE changelog

## Credits

* [Emma "MayMeow" Watson](https://github.com/MayMeow)

## License

MIT