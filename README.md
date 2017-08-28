# May Encrypt

Library for signing certificates with selfsigned CA

## Installation

Install with docker:
```bash
composer require maymeow/may-encrypt
```

And intialize it withhin your script
```php
$cf = new \MayMeow\Factory\CertificateFactory();
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
