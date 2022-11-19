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


use zxtouch\element\value\IntegerValue;


class IntegerResult extends Result{

    private int $value;

    public function __construct(bool $result, string $errorMessage, int $value){
        parent::__construct($result, $errorMessage);

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue() : int{
        return $this->value;
    }

    /**
     * @return IntegerValue
     */
    public function asIntegerValue() : IntegerValue{
        return new IntegerValue($this->value);
    }

}