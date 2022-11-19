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

namespace zxtouch\element\touch;


use zxtouch\element\Coordinates;
use zxtouch\ZXTouchException;


abstract class Touch{

    public function __construct(
        private int $fingerIndex,
        private Coordinates $coordinates
    ){
        if($this->fingerIndex <= 0 || $this->fingerIndex > 19){
            throw new ZXTouchException('Touch index must be between 1 and 18.');
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
        return $this->coordinates->getX();
    }

    /**
     * @return int
     */
    public function getY() : int{
        return $this->coordinates->getY();
    }

    /**
     * Update the coordinates to touch
     *
     * @param Coordinates $coordinates
     */
    public function setCoordinates(Coordinates $coordinates) : void{
        $this->coordinates = $coordinates;
    }

    /**
     * @param int $fingerIndex
     */
    public function setFingerIndex(int $fingerIndex) : void{
        $this->fingerIndex = $fingerIndex;
    }

    /**
     * @return string
     */
    final public function getBuffer() : string{
        return $this->getType() . str_pad((string) $this->getFingerIndex(), 2, '0', STR_PAD_LEFT) . str_pad((string) ($this->getX() * 10), 5, '0', STR_PAD_LEFT) . str_pad((string) ($this->getY() * 10), 5, '0', STR_PAD_LEFT);
    }

}