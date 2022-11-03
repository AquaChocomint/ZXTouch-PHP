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


class AppIdentifier{

    public function __construct(
        private string $identifier
    ){
    }

    /**
     * @return string
     */
    public function getIdentifier() : string{
        return $this->identifier;
    }

}