<?php


require_once 'vendor/autoload.php';


use PHPUnit\Framework\TestCase;
use zxtouch\element\touch\TouchDown;
use zxtouch\element\touch\TouchUp;
use zxtouch\ZXTouch;
use zxtouch\ZXTouchException;


class ZXTouchTest extends TestCase{

    public function testZXTouch() : void{
        try{
            $zx = new ZXTouch('192.168.0.23');
            $zx->touch(new TouchDown(1, 569, 2301));
            usleep(800000);
            $zx->touch(new TouchUp(1, 569, 2301));
            $zx->disconnect();
        }catch(ZXTouchException $exception){
            echo $exception->getMessage();
        }
    }

}