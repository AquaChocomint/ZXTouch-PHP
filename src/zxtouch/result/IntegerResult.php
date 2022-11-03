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

}