<?php

/*
 * This file is part of ZXTouch-PHP.
 *
 * (c) AquaChocomint
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace zxtouch\element\touch;


use zxtouch\ZXTouchException;


abstract class Touch{

    public function __construct(
        private int $fingerIndex,
        private int $x,
        private int $y
    ){
        if($this->fingerIndex > 19){
            throw new ZXTouchException('Touch index should not be greater than 19.');
        }
    }

    abstract public function getType() : int;

    /**
     * @return int
     */
    public function getFingerIndex() : int{
        return $this->fingerIndex;
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
     * @return string
     */
    final public function getBuffer() : string{
        return $this->getType() . str_pad($this->getFingerIndex(), 2, '0', STR_PAD_LEFT) . str_pad((string) ($this->getX() * 10), 5, '0', STR_PAD_LEFT) . str_pad((string) ($this->getY() * 10), 5, '0', STR_PAD_LEFT);
    }

}