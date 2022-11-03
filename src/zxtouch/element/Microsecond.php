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


class Microsecond{

    public function __construct(
        private int $microsecond
    ){
    }

    /**
     * @return int
     */
    public function getMicrosecond() : int{
        return $this->microsecond;
    }

}