<?php

namespace MayMeow\Cryptography\Cert;

interface SerializableInterface
{
    public function serialize();

    public function toArray() : array;
}