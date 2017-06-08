<?php
/**
 * This file is part of MayMeow/encrypt project
 * Copyright (c) 2017 Charlotta Jung
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 * @copyright Copyright (c) Charlotta MayMeow Jung
 * @link      http://maymeow.click
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * @project may-encrypt
 * @file domainName.php
 */

include_once '../vendor/autoload.php';

include_once '../config/app.php';

/*$caf = new \MayMeow\Factory\CertificateFactory();

$caf->domainName()
    ->setCommonName('May Encrypt Intermediate')
    ->setCountryName('SK')
    ->setOrganizationName('MayMeow click');

//var_dump($caf->type('ca')->sign());

$caf->type('intermediate')->ca('ca')->sign();*/

// ca
/*$ca = new \MayMeow\Factory\CertificateFactory();

$ca->domainName()
    ->setCommonName('May Encrypt CA')
    ->setCountryName('SK')
    ->setOrganizationName('May Meow');

$ca->setType('ca')->setName('may-encrypt')->sign()->toFile();*/

// intermediate

/*$intermediate = new \MayMeow\Factory\CertificateFactory();

$intermediate->domainName()
    ->setCommonName('May Encrypt Intermediate CA')
    ->setCountryName('SK')
    ->setOrganizationName('May Meow');

$intermediate->setType('intermediate')
    ->setName('may-intermediate-ca')
    ->setCa('may-encrypt', 7880)
    ->sign()->toFile();*/

// user

$cf = new \MayMeow\Factory\CertificateFactory();

/*$cf->domainName()
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setCountryName('SK')
    ->setCommonName('Hogwarts School of Witchcraft and Wizardry Root CA');

$cf->setType('ca')
    ->setName('Hogwarts')
    ->sign()->toFile();*/

/*$cf->domainName()
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setCountryName('SK')
    ->setOrganizationalUnitName('Hogwarts houses')
    ->setCommonName('Slytherin HSoWaW House');

$cf->setType('intermediate')
    ->setName('Hogwarts/Slytherin')
    ->setCa('Hogwarts', '200634')
    ->sign()->toFile();*/


/*$cf->domainName()
    ->setCommonName('Hermione Granger')
    ->setEmailAddress('hermione.granger@g.hogwarts.local')
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setOrganizationalUnitName('Hogwarts Students');

$cf->setType('user')
    ->setName('Hogwarts/Students/hermione-granger')
    ->setCa('Hogwarts/Gryffindor', '296545')
    ->sign()->toFile(true);*/

/*$cf->domainName()
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
    ->sign()->toFile();*/

/*$user->domainName()
    ->setCommonName('Emma Jung')
    ->setEmailAddress('emma@kukolos.sk');

$user->getAltNames()
    ->setDns('kukolos.sk')
    ->setDns('gitlab.cafe')
    ->setDns('*.kukolos.sk')
    ->setIp('127.0.0.1');

$crt = $user->setType('user')
    ->setName('Emma-Jung')
    ->setCa('intermediate', 10321033)
    ->sign()->toFile(true);*/

/*$cf->domainName()
    ->setCommonName('Metalport Kosice')
    ->setOrganizationName('Metalport s.r.o.')
    ->setCountryName('SK')
    ->setLocalityName('Kosice');

$cf->getAltNames()
    ->setIp('85.159.105.164');

$cf->setType('server')
    ->setName('Metalport-Kosice')
    ->setCa('intermediate', 10321033)
    ->sign()->toFile();

print_r(json_decode($crt));*/

// server

/*$server = new \MayMeow\Factory\CertificateFactory();

$server->setType('server', [
    'DNS=webmail.zsokruzna.sk',
    'DNS=vpn.zsokruzna.sk',
])->setName('')
    ->setCa('may-intermediate-ca')
    ->sign();*/

$sf = new \MayMeow\Factory\SecurityFactory();

/*$string = json_encode([
    "name" => 'Hello',
    "surname" => 'world'
]);

$message = $sf->addRecipientKey('Hogwarts/Students/hermione-granger')
    ->addRecipientKey('Hogwarts/Students/Harry-potter')
    ->setString($string)->seal();

$sf2 = new \MayMeow\Factory\SecurityFactory();
$sf2->setPrivateKey('Hogwarts/Students/hermione-granger', '102197');
$msg = $sf2->setString($message['sealed'])->open($message['keys'][0]);

var_dump($msg);*/

/*$sf->setPrivateKey('Hogwarts/Students/hermione-granger', '102197');
$sf->setPublicKey('Hogwarts/Students/hermione-granger');
$signature = $sf->setString('Ahoj')->sign();

echo $sf->setString("Ahoj")->verify($signature);*/

/*$cf->domainName()
    ->setCommonName("webmail.zsokruzna.sk")
    ->setOrganizationalUnitName("VPN")
    ->setOrganizationName("Zakladna skola Okruzna 6 Michalovce");

$cf->getAltNames()
    ->setDns("webmail.zsokruzna.sk")
    ->setDns("vpn.zsokruzna.sk");

$cf->setType("server")
    ->setName("Gnoma/Webpages/webmail-zsokruzna-sk")
    ->setCa('Gnoma/intermediate', '10321033')
    ->sign()->toFile();*/

$cf->domainName()
    ->setCommonName('MetalPort Puskinova')
    ->setOrganizationalUnitName('VPN')
    ->setOrganizationName('Metalport s.r.o.');

$cf->getAltNames()
    ->setIp('188.120.15.51');

$cf->setType('server')
    ->setName('Gnoma/Webpages/metalport-trebisov')
    ->setCa('Gnoma/intermediate', '10321033')
    ->sign()->toFile();

