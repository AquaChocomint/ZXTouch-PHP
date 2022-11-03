<?php

/*
 * This file is part of ZXTouch-PHP.
 *
 * (c) AquaChocomint
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace zxtouch\element;


class TextRecognitionLevel{

    /**
     * A value that determines whether the request prioritizes accuracy or speed in text recognition. 0 means accurate. 1 means faster.
     *
     * @param int $value
     */
    public function __construct(
        private int $value
    ){
    }

    /**
     * @return int
     */
    public function getRecognitionLevel() : int{
        return $this->value;
    }

}