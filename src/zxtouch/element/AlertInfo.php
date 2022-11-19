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

    /**
     * @param string $title
     *
     * @return AlertInfo
     */
    public function setTitle(string $title) : AlertInfo{
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $content
     *
     * @return AlertInfo
     */
    public function setContent(string $content) : AlertInfo{
        $this->content = $content;

        return $this;
    }

    /**
     * @param int $duration
     *
     * @return AlertInfo
     */
    public function setDuration(int $duration) : AlertInfo{
        $this->duration = $duration;

        return $this;
    }

}