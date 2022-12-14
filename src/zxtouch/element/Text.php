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


class Text{

    public const BACKSPACE_CHARACTER = "\b"; //For ZXTouch::insertText() only

    public function __construct(
        private string $text
    ){
    }

    /**
     * @return string
     */
    public function getText() : string{
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Text
     */
    public function setText(string $text) : Text{
        $this->text = $text;

        return $this;
    }

}