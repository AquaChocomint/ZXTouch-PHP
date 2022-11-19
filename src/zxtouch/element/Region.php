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
     * @param int $x
     *
     * @return Region
     */
    public function setX(int $x) : Region{
        $this->x = $x;

        return $this;
    }

    /**
     * @param int $y
     *
     * @return Region
     */
    public function setY(int $y) : Region{
        $this->y = $y;

        return $this;
    }

    /**
     * @param int $width
     *
     * @return Region
     */
    public function setWidth(int $width) : Region{
        $this->width = $width;

        return $this;
    }

    /**
     * @param int $height
     *
     * @return Region
     */
    public function setHeight(int $height) : Region{
        $this->height = $height;

        return $this;
    }

    /**
     * @return string
     */
    final public function toOCR() : string{
        return ((string) $this->x) . ',,' . ((string) $this->y) . ',,' . ((string) $this->width) . ',,' . ((string) $this->height);
    }

}