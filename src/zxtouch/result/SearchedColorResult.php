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

namespace zxtouch\result;


class SearchedColorResult extends Result{

    private int $x;
    private int $y;
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(bool $result, string $errorMessage, int $x, int $y, int $red, int $green, int $blue){
        parent::__construct($result, $errorMessage);

        $this->x = $x;
        $this->y = $y;
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
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
    public function getRed() : int{
        return $this->red;
    }

    /**
     * @return int
     */
    public function getGreen() : int{
        return $this->green;
    }

    /**
     * @return int
     */
    public function getBlue() : int{
        return $this->blue;
    }

}