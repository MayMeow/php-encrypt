---
title: "Cerification Authority [WIP]"
description: ""
date: 2021-01-23T14:53:44+01:00
lastmod: 2021-01-23T14:53:44+01:00
draft: false
images: []
menu:
  docs:
    parent: "help"
weight: 203
toc: true
---

Example

```php
public function testWighCA()
{
    // Add certificate informations
    $csr = new \MayMeow\Cryptography\Cert\CertParameters();
    $csr->setCommonName('EmmaX');

    $ca = new \MayMeow\Cryptography\Authority\CertificateAuthority();

    // this is your selfsigned certificate
    $certificate = $ca->createSelfSigned($csr, 'user', 7000);

    $path = WWW_ROOT . $certificate->getCertParameters()->getCommonName() . DS;

    if (!file_exists($path)) {
        mkdir($path);
    }

    // Write Certificaate to file
    openssl_x509_export_to_file($certificate->getSignedCert(), $path . 'cert.crt');

    // Write primaary key to file
    openssl_pkey_export_to_file($certificate->getPrivateKey(),
        $path . 'key.pem', $certificate->getEncryptionPass(), $certificate->getConfigArgs());

    // Write PCKS12
    openssl_pkcs12_export_to_file($certificate->getSignedCert(),
        $path . 'cert.pfx', $certificate->getPrivateKey(), $certificate->getEncryptionPass(),
        $certificate->getConfigArgs());
}
```