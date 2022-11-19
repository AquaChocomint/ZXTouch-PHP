<?php


namespace tests;


use zxtouch\element\Coordinates;
use zxtouch\element\touch\TouchDown;
use zxtouch\element\touch\TouchUp;
use zxtouch\ZXTouchException;


class TouchTest extends ZXTouchTestBase{

    public function testTouch() : void{
        $coordinates = new Coordinates(170, 300);

        try{
            $this->zx->touch(new TouchDown(1, $coordinates));
            usleep(80000);
            $this->zx->touch(new TouchUp(1, $coordinates));

            self::assertTrue(true);
        }catch(ZXTouchException $exception){
            echo $exception->getMessage();
        }
    }

}