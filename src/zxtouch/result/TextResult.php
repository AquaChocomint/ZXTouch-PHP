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


use zxtouch\element\Text;


class TextResult extends Result{

    private string $text;

    public function __construct(bool $result, string $errorMessage, string $text){
        parent::__construct($result, $errorMessage);

        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText() : string{
        return $this->text;
    }

    /**
     * Convert text to Text instance
     *
     * @return Text
     */
    public function asTextInstance() : Text{
        return new Text($this->text);
    }

}