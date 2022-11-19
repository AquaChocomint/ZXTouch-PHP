<?php


namespace tests;


use zxtouch\element\Text;


class ClipboardTest extends ZXTouchTestBase{

    public function testClipboard() : void{
        $this->zx->setClipboard(new Text('I like it.'));
        $result = $this->zx->pasteClipboard();

        self::assertTrue($result->hasResult());
    }

}