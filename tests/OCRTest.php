<?php


namespace tests;


use zxtouch\element\OCR;
use zxtouch\element\value\IntegerValue;


class OCRTest extends ZXTouchTestBase{

    public function testOCR() : void{
        $recognition = new IntegerValue(1);
        $screen = $this->zx->getScreenSize(); //Get the screen size
        $region = $screen->asFullRegion(); //Convert to Region instance

        $languages = $this->zx->getSupportedOCRLanguages($recognition);

        self::assertTrue($languages->hasResult());

        echo 'Supported Languages:' . implode(', ', $languages->getLanguages()) . PHP_EOL;

        echo PHP_EOL;

        echo 'Detecting texts...' . PHP_EOL;

        $result = $this->zx->ocr($region, new OCR(recognitionLevel: $recognition->getValue()));
        $response = $result->hasResult();

        if($response){
            $texts = $result->getTexts();
            foreach($texts as $text){
                echo 'Text: ' . $text->getText() . ' (X: ' . $text->getX() . ', Y: ' . $text->getY() . ' | WxH: ' . $text->getWidth() . 'x' . $text->getHeight() . ')' . PHP_EOL;
            }
        }else{
            echo $result->getErrorMessage();
        }

        self::assertTrue($response);
    }

}