<?php


namespace tests;


use zxtouch\element\AlertInfo;


class SendAlertBoxTest extends ZXTouchTestBase{

    public function testAlertBox() : void{
        $result = $this->zx->sendAlertBox(new AlertInfo(
            'Alert Title',
            'Hi. I\'m AquaChocomint :)',
            3
        ));

        self::assertTrue($result->hasResult());
    }

}