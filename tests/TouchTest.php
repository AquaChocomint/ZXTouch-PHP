<?php


namespace tests;


use zxtouch\element\touch\TouchDown;
use zxtouch\element\touch\TouchUp;
use zxtouch\ZXTouchException;


class TouchTest extends ZXTouchTestBase{

    public function testTouch() : void{
        try{
            $this->zx->touch(new TouchDown(1, 569, 2301));
            usleep(800000);
            $this->zx->touch(new TouchUp(1, 569, 2301));
        }catch(ZXTouchException $exception){
            echo $exception->getMessage();
        }
    }

}