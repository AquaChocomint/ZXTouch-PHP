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

namespace zxtouch\element;


class OCR{

    /**
     * @param string[]     $words An array of strings to supplement the recognized languages at the word recognition stage.
     * @param float|string $minimumHeight The minimum height of the text expected to be recognized, relative to the image height. The default value is 1/32
     * @param int $recognitionLevel A value that determines whether the request prioritizes accuracy or speed in text recognition. 0 means accurate. 1 means faster.
     * @param string[]     $languages An array of languages to detect, in priority order.  Default: english. Use ZXTouch::getSupportedOcrLanguages() to get the language list.
     * @param int          $autoCorrect Whether ocr engine applies language correction during the recognition process. 0 means no, 1 means yes
     * @param string       $debugImagePath Debug image path. If you DONT want the ocr engine to output the debug image, leave it blank
     */
    public function __construct(
        private array $words = [],
        private float|string $minimumHeight = '',
        private int $recognitionLevel = 0,
        private array $languages = [],
        private int $autoCorrect = 0,
        private string $debugImagePath = ''
    ){
    }

    /**
     * @return string
     */
    public function getConvertedWords() : string{
        return implode(',,', $this->words);
    }

    /**
     * @return float|string
     */
    public function getMinimumHeight() : float|string{
        return $this->minimumHeight;
    }

    /**
     * @return int
     */
    public function getRecognitionLevel() : int{
        return $this->recognitionLevel;
    }

    /**
     * @return string
     */
    public function getConvertedLanguages() : string{
        return implode(',,', $this->languages);
    }

    /**
     * @return int
     */
    public function getAutoCorrect() : int{
        return $this->autoCorrect;
    }

    /**
     * @return string
     */
    public function getDebugImagePath() : string{
        return $this->debugImagePath;
    }

    /**
     * @param string[] $words
     *
     * @return OCR
     */
    public function setWords(array $words) : OCR{
        $this->words = $words;

        return $this;
    }

    /**
     * @param float|string $minimumHeight
     *
     * @return OCR
     */
    public function setMinimumHeight(float|string $minimumHeight) : OCR{
        $this->minimumHeight = $minimumHeight;

        return $this;
    }

    /**
     * @param int $recognitionLevel
     *
     * @return OCR
     */
    public function setRecognitionLevel(int $recognitionLevel) : OCR{
        $this->recognitionLevel = $recognitionLevel;

        return $this;
    }

    /**
     * @param string[] $languages
     *
     * @return OCR
     */
    public function setLanguages(array $languages) : OCR{
        $this->languages = $languages;

        return $this;
    }

    /**
     * @param int $autoCorrect
     *
     * @return OCR
     */
    public function setAutoCorrect(int $autoCorrect) : OCR{
        $this->autoCorrect = $autoCorrect;

        return $this;
    }

    /**
     * @param string $debugImagePath
     *
     * @return OCR
     */
    public function setDebugImagePath(string $debugImagePath) : OCR{
        $this->debugImagePath = $debugImagePath;

        return $this;
    }

}