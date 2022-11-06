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


class Coordinates{

    public function __construct(
        private int $x,
        private int $y
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

}