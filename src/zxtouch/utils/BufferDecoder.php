<?php

/*
 * This file is part of ZXTouch-PHP.
 *
 * (c) AquaChocomint
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace zxtouch\utils;


use zxtouch\result\BatteryInfoResult;
use zxtouch\result\DeviceInfoResult;
use zxtouch\result\IntegerResult;
use zxtouch\result\ocr\OCRResult;
use zxtouch\result\ocr\OCRSupportedLanguagesResult;
use zxtouch\result\PickedColorResult;
use zxtouch\result\DefaultResult;
use zxtouch\result\MatchingImageResult;
use zxtouch\result\ScreenSizeResult;
use zxtouch\result\SearchedColorResult;


class BufferDecoder{

    /** @var string[] */
    private array $details = [];
    private string $error = '';
    private bool $result;

    public function __construct(
        private string $buffer
    ){
        $this->decode();
    }

    public function getBatteryInfoResult() : BatteryInfoResult{
        return new BatteryInfoResult($this->result, $this->error, (int) array_shift($this->details), (int) array_shift($this->details));
    }

    public function getDefaultResult() : DefaultResult{
        return new DefaultResult($this->result, $this->error, (string) array_shift($this->details));
    }

    public function getDeviceInfoResult() : DeviceInfoResult{
        return new DeviceInfoResult($this->result, $this->error, (string) array_shift($this->details), (string) array_shift($this->details), (string) array_shift($this->details), (string) array_shift($this->details), (string) array_shift($this->details));
    }

    public function getIntegerResult() : IntegerResult{
        return new IntegerResult($this->result, $this->error, (int) array_shift($this->details));
    }

    public function getMatchingImageResult() : MatchingImageResult{
        return new MatchingImageResult($this->result, $this->error, (int) array_shift($this->details), (int) array_shift($this->details), (int) array_shift($this->details), (int) array_shift($this->details));
    }

    public function getOCRResult() : OCRResult{
        return new OCRResult($this->result, $this->error, $this->details);
    }

    public function getOCRSupportedLanguagesResult() : OCRSupportedLanguagesResult{
        return new OCRSupportedLanguagesResult($this->result, $this->error, $this->details);
    }

    public function getPickedColorResult() : PickedColorResult{
        return new PickedColorResult($this->result, $this->error, (int) array_shift($this->details), (int) array_shift($this->details), (int) array_shift($this->details));
    }

    public function getScreenSizeResult() : ScreenSizeResult{
        return new ScreenSizeResult($this->result, $this->error, (int) array_shift($this->details), (int) array_shift($this->details));
    }

    public function getSearchedColorResult() : SearchedColorResult{
        return new SearchedColorResult($this->result, $this->error, (int) array_shift($this->details), (int) array_shift($this->details), (int) array_shift($this->details), (int) array_shift($this->details), (int) array_shift($this->details));
    }

    /**
     * @return string[]
     */
    public function getDetails() : array{
        return $this->details;
    }

    private function decode() : void{
        $response = explode(';;', str_replace("\r\n", "", $this->buffer));
        $this->result = array_shift($response) === '0';

        if($this->result){
            $this->details = $response;
        }else{
            $this->error = (string) array_shift($response);
        }
    }

}