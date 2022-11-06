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


class OCRText{

    public function __construct(
        private string $text,
        private int $x,
        private int $y,
        private int $width,
        private int $height
    ){
    }

    /**
     * @return string
     */
    public function getText() : string{
        return $this->text;
    }

    /**
     * @return int
     */
    public function getX() : int{
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY() : int{
        return $this->y;
    }

    /**
     * @return int
     */
    public function getWidth() : int{
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight() : int{
        return $this->height;
    }

}