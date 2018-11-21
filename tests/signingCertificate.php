<?php

use MayMeow\Factory\CertificateFactory;
use MayMeow\Model\EncryptConfiguration;


include_once '../vendor/autoload.php';

include_once '../config/app.php';

/*$ca = new CertificateFactory(new EncryptConfiguration());

$ca->domainName()
    ->setCommonName('Hogwarts root CA')
    ->setCountryName('SK')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry');

$ca->setType('ca')->setName('hogwarts-root-ca')->sign()->toFile();*/


/*$ica = new CertificateFactory(new EncryptConfiguration());

$ica->domainName()
    ->setCommonName('Hogwarts Intermediate CA')
    ->setCountryName('SK')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry');

$ica->setType('intermediate')
    ->setName('hogwarts-intermediate-ca')
    ->setCa('hogwarts-root-ca', 151074)
    ->sign()->toFile();*/

$csc = new CertificateFactory(new EncryptConfiguration());

$csc->domainName()
    ->setCommonName('Martin Kukolos')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setOrganizationalUnitName('Hogwarts Students');

$csc->setType('code_sign')
    ->setName('Hogwarts/Students/martin-kukolos')
    ->setCa('hogwarts-intermediate-ca', '776743')
    ->sign()->toFile(['pcks12' => true]);