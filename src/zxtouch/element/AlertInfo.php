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


class AlertInfo{

    public function __construct(
        private string $title,
        private string $content,
        private int $duration
    ){
    }

    /**
     * @return string
     */
    public function getTitle() : string{
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent() : string{
        return $this->content;
    }

    /**
     * @return int
     */
    public function getDuration() : int{
        return $this->duration;
    }

}