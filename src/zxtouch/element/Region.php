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


class Region{

    /**
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     */
    public function __construct(
        private int $x,
        private int $y,
        private int $width,
        private int $height
    ){
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

    /**
     * @return string
     */
    public function toOCR() : string{
        return ((string) $this->x) . ',,' . ((string) $this->y) . ',,' . ((string) $this->width) . ',,' . ((string) $this->height);
    }

}