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


class ShellCommand{

    public function __construct(
        private string $command
    ){
    }

    /**
     * @return string
     */
    public function getCommand() : string{
        return $this->command;
    }

}