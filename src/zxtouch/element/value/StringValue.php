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


class StringValue{

    /**
     * @param string $value
     */
    public function __construct(
        private string $value
    ){
    }

    /**
     * @return string
     */
    public function getValue() : string{
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return StringValue
     */
    public function setValue(string $value) : StringValue{
        $this->value = $value;

        return $this;
    }

}