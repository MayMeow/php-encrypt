---
title: "Quick Start"
description: "How to use PHP Encrypt in my project."
lead: "How to use PHP Encrypt in my project."
date: 2020-11-16T13:59:39+01:00
lastmod: 2020-11-16T13:59:39+01:00
draft: false
images: []
menu:
  docs:
    parent: "prologue"
weight: 102
toc: true
---

## Installation

Install with docker:
```bash
composer require maymeow/php-encrypt
```

And intialize it withhin your script
```php
$cf = new \MayMeow\Factory\CertificateFactory(new \MayMeow\Model\EncryptConfiguration());
```

Make sure you meet the [following requirements]({{< ref "requirements" >}})