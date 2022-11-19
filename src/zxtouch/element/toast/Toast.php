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

namespace zxtouch\element\toast;


abstract class Toast{

    public const POSITION_TOP = 0;
    public const POSITION_BOTTOM = 1;
    public const POSITION_LEFT = 2;
    public const POSITION_RIGHT = 3;

    public function __construct(
        private string $content,
        private int $duration,
        private int $position = self::POSITION_TOP,
        private int $fontSize = 0
    ){
    }

    abstract public function getType() : int;

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
     * @return int
     */
    public function getPosition() : int{
        return $this->position;
    }

    /**
     * @return int
     */
    public function getFontSize() : int{
        return $this->fontSize;
    }

    /**
     * @param string $content
     *
     * @return Toast
     */
    public function setContent(string $content) : Toast{
        $this->content = $content;

        return $this;
    }

    /**
     * @param int $duration
     *
     * @return Toast
     */
    public function setDuration(int $duration) : Toast{
        $this->duration = $duration;

        return $this;
    }

    /**
     * @param int $position
     *
     * @return Toast
     */
    public function setPosition(int $position) : Toast{
        $this->position = $position;

        return $this;
    }

    /**
     * @param int $fontSize
     *
     * @return Toast
     */
    public function setFontSize(int $fontSize) : Toast{
        $this->fontSize = $fontSize;

        return $this;
    }

}