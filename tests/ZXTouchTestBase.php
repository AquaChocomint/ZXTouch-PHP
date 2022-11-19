<?php


namespace tests;


use PHPUnit\Framework\TestCase;
use zxtouch\ZXTouch;


abstract class ZXTouchTestBase extends TestCase{

    protected ZXTouch $zx;

    protected function setUp() : void{
        $this->zx = new ZXTouch('192.168.0.8');
    }

    protected function tearDown() : void{
        $this->zx->disconnect();
    }

}