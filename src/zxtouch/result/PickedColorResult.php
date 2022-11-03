<?php

/*
 * This file is part of ZXTouch-PHP.
 *
 * (c) AquaChocomint
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace zxtouch\result;


class PickedColorResult extends Result{

    private int $red;
    private int $green;
    private int $blue;

    public function __construct(bool $result, string $errorMessage, int $red, int $green, int $blue){
        parent::__construct($result, $errorMessage);

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
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