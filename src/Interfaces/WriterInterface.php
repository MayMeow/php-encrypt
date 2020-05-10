<?php

namespace MayMeow\Interfaces;

use MayMeow\Cert\X509Certificate2;

interface WriterInterface
{
    public function setCert(X509Certificate2 $cert);

    public function setName($name);

    public function setCertConfiguration($certConfiguration);

    public function write($decryptPK = false, $pcks12 = false);
}