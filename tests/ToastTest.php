<?php


namespace tests;


use zxtouch\element\toast\ToastError;
use zxtouch\element\toast\ToastMessage;
use zxtouch\element\toast\ToastSuccess;
use zxtouch\element\toast\ToastWarning;


class ToastTest extends ZXTouchTestBase{

    public function testToast() : void{
        $this->zx->sendToast(new ToastSuccess('Success Toast', 2));
        sleep(2);
        $this->zx->sendToast(new ToastError('Error Toast', 2));
        sleep(2);
        $this->zx->sendToast(new ToastMessage('Default Toast', 2));
        sleep(2);
        $this->zx->sendToast(new ToastWarning('Warning Toast', 2));
    }

}