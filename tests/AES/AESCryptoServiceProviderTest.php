<?php
namespace MayMeow\Tests\AES;

use MayMeow\Cryptography\AES\AESCryptoServiceProvider;
use MayMeow\Tests\TestCase;

class AESCryptoServiceProviderTest extends TestCase
{
    /** @var AESCryptoServiceProvider */
    protected $csp;

    public function setup()
    {
        parent::setUp();

        $this->csp = new AESCryptoServiceProvider();
    }

    /** @test */
    public function testEncryption()
    {
        $this->csp->generateIV();
        $key = $this->csp->generateKey();

        $plainText = "This is going to be encrypted!";
        $encryptedText = $this->csp->encrypt($plainText);

        $csp2 = new AESCryptoServiceProvider();
        $csp2->setKey($key);

        $this->assertEquals($plainText, $csp2->decrypt($encryptedText));
    }
}