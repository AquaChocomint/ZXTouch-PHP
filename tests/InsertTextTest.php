<?php


namespace tests;


use zxtouch\element\Text;


class InsertTextTest extends ZXTouchTestBase{

    public function testInsertText() : void{
        $text = 'Hello, I\'m AquaChocomm';
        $text .= Text::BACKSPACE_CHARACTER;
        $text .= 'int';

        $this->zx->insertText(new Text($text));

        self::assertTrue(true);
    }

}