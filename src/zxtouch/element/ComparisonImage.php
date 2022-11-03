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


class ComparisonImage{

    /**
     * @param string $path
     * @param float  $acceptableValue
     * @param int    $maxTryTimes
     * @param float  $scaleRation
     */
    public function __construct(
        private string $path,
        private float $acceptableValue = 0.8,
        private int $maxTryTimes = 4,
        private float $scaleRation = 0.8,
    ){
    }

    /**
     * @return string
     */
    public function getPath() : string{
        return $this->path;
    }

    /**
     * @return float
     */
    public function getAcceptableValue() : float{
        return $this->acceptableValue;
    }

    /**
     * @return int
     */
    public function getMaxTryTimes() : int{
        return $this->maxTryTimes;
    }

    /**
     * @return float
     */
    public function getScaleRation() : float{
        return $this->scaleRation;
    }

}