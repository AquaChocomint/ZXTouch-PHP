<?php

/*
 * This file is part of ZXTouch-PHP.
 *
 * (c) AquaChocomint
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace zxtouch\result\ocr;


use zxtouch\result\Result;


class OCRSupportedLanguagesResult extends Result{

    private array $languages;

    public function __construct(bool $result, string $errorMessage, array $languages){
        parent::__construct($result, $errorMessage);

        $this->languages = $languages;
    }

    /**
     * @return string[]
     */
    public function getLanguages() : array{
        return $this->languages;
    }

}