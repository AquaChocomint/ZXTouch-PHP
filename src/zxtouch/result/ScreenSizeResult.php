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


use zxtouch\element\Region;


class ScreenSizeResult extends Result{

    private int $width;
    private int $height;

    public function __construct(bool $result, string $errorMessage, int $width, int $height){
        parent::__construct($result, $errorMessage);

        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth() : int{
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight() : int{
        return $this->height;
    }

    /**
     * Return a Region instance that selects all screen area
     *
     * @return Region
     */
    public function asFullRegion() : Region{
        return new Region(0, 0, $this->width, $this->height);
    }

}