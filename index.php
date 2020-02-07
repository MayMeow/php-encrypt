<?php

include_once './vendor/autoload.php';
include_once './config/app.php';

$cf1 = new \MayMeow\Factory\CertificateFactory(new \MayMeow\Model\EncryptConfiguration());
$cf2 = new \MayMeow\Factory\CertificateFactory(new \MayMeow\Model\EncryptConfiguration());

/*$cf->domainName()
    ->setCommonName('Hogwarts College Root CA')
    ->setCountryName('SK')
    ->setOrganizationName('Hogwarts College');

$cf->setType('ca')
    ->setName('hogwarts-college')
    ->sign()
    ->toFile(['pcks12' => true]);*/

/*$cf->domainName()
    ->setCommonName('Hogwarts College Intermediate CA')
    ->setCountryName('SK')
    ->setOrganizationName('Hogwarts College');

$cf->setType('intermediate')
    ->setName('hogwarts-college/intermediate')
    ->setCa('hogwarts-college', 808435)
    ->sign()->toFile(['pcks12' => true]);*/


$cf1->domainName()
    ->setCommonName('Martin Kukolos');

$cf1->setType('code_sign')
    ->setName('hogwarts-college/students/martin-kukolos-sha256')
    ->setCa('hogwarts-college/intermediate', '711907')
    ->sign()->toFile(['pcks12' => true]);

$cf2->domainName()
    ->setCommonName('Martin Kukolos');

$cf2->setType('code_sign')
    ->setName('hogwarts-college/students/martin-kukolos-sha1')
    ->setCa('hogwarts-college/intermediate', '711907')
    ->sign('sha1')->toFile(['pcks12' => true]);