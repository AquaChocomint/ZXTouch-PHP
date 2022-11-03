<?php


namespace tests;


use zxtouch\element\AlertInfo;


class SendAlertBoxTest extends ZXTouchTestBase{

    public function testAlertBox() : void{
        $this->zx->sendAlertBox(new AlertInfo(
            'Alert Title',
            'Hi. I\'m AquaChocomint :)',
            3
        ));
    }

}