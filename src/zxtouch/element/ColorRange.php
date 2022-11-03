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


class ColorRange{

    private int $colorMin;
    private int $colorMax;

    /**
     * Type the range of colors you want to search for.
     * Minimum and maximum values need not be considered.
     *
     * @param int $color1
     * @param int $color2
     */
    public function __construct(int $color1, int $color2){
        $this->colorMin = min($color1, $color2);
        $this->colorMax = min($color1, $color2);
    }

    /**
     * @return int
     */
    public function getColorMin() : int{
        return $this->colorMin;
    }

    /**
     * @return int
     */
    public function getColorMax() : int{
        return $this->colorMax;
    }

}