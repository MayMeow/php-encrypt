---
title: "Create selfsigned Certifiation authority"
description: ""
date: 2021-01-23T14:21:41+01:00
lastmod: 2021-01-23T14:21:41+01:00
draft: false
images: []
menu:
  docs:
    parent: "older-docs"
weight: 301
toc: true
---

In first to create other certificate you will need to have Certificate Authority

## Create Root Certification authority

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

## Create Intermediate certification Authority (optiional)

I use intermediate authority to sighn other users certificates. You can have how many authorities you want but it is not necessary. If you like just use your ROOT CA to sign
users certificates.

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