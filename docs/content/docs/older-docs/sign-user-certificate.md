---
title: "Sign User Certificate"
description: "Example for signing user certificate"
lead: "Example for signing user certificate"
date: 2021-01-23T14:35:13+01:00
lastmod: 2021-01-23T14:35:13+01:00
draft: false
images: []
menu:
  docs:
    parent: "older-docs"
weight: 302
toc: true
---

You will need to create Root and Intermediate CAs certificates.

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