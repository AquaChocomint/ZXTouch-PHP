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

namespace zxtouch\element\value;


class IntegerValue{

    public function __construct(
        private int $value
    ){
    }

    /**
     * @return int
     */
    public function getValue() : int{
        return $this->value;
    }

    /**
     * @param int $value
     *
     * @return IntegerValue
     */
    public function setValue(int $value) : IntegerValue{
        $this->value = $value;

        return $this;
    }

}