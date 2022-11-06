<?php

/*
 * This file is part of ZXTouch-PHP.
 *
 * (c) AquaChocomint
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace zxtouch\result\ocr;


use zxtouch\result\Result;


class OCRResult extends Result{

    /** @var OCRText[] */
    private array $texts = [];

    public function __construct(bool $result, string $errorMessage, array $details){
        parent::__construct($result, $errorMessage);

        $this->setOCRs($details);
    }

    /**
     * @return OCRText[]
     */
    public function getTexts() : array{
        return $this->texts;
    }

    private function setOCRs(array $details) : void{
        foreach($details as $detail){
            $split = explode(',,', $detail);
            $this->texts[] = new OCRText(
                array_shift($split),
                (int) array_shift($split) ?? 0,
                (int) array_shift($split) ?? 0,
                (int) array_shift($split) ?? 0,
                (int) array_shift($split) ?? 0
            );
        }
    }

}