<?php


namespace tests;


use zxtouch\element\toast\ToastError;
use zxtouch\element\toast\ToastMessage;
use zxtouch\element\toast\ToastSuccess;
use zxtouch\element\toast\ToastWarning;


class ToastTest extends ZXTouchTestBase{

    public function testToast() : void{
        $result = $this->zx->sendToast(new ToastSuccess('Success Toast', 2));
        self::assertTrue($result->hasResult());
        sleep(2);

        $result = $this->zx->sendToast(new ToastError('Error Toast', 2));
        self::assertTrue($result->hasResult());
        sleep(2);

        $result = $this->zx->sendToast(new ToastMessage('Default Toast', 2));
        self::assertTrue($result->hasResult());
        sleep(2);

        $result = $this->zx->sendToast(new ToastWarning('Warning Toast', 2));
        self::assertTrue($result->hasResult());
    }

}