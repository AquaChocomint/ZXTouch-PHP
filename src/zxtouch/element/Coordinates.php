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

    /**
     * @param int $x
     *
     * @return Coordinates
     */
    public function setX(int $x) : Coordinates{
        $this->x = $x;

        return $this;
    }

    /**
     * @param int $y
     *
     * @return Coordinates
     */
    public function setY(int $y) : Coordinates{
        $this->y = $y;

        return $this;
    }

    /**
     * Clone this coordinates instance
     *
     * @return Coordinates
     */
    public function copy() : Coordinates{
        return new Coordinates($this->x, $this->y);
    }

}