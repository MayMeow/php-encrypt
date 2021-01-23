---
title: "Sign Server Certificate"
description: "Example for signing server certificates"
date: 2021-01-23T14:37:37+01:00
lastmod: 2021-01-23T14:37:37+01:00
draft: false
images: []
menu:
  docs:
    parent: "older-docs"
weight: 303
toc: true
---

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

### PKCS12 file format

Windows users need certificate in PKCS12 format, `.pfx` file extension. To create this type of file use

```php
// public function write($decryptPK = false, $pcks12 = false);
...->write(false, true);
```