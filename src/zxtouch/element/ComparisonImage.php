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

    /**
     * @param string $path
     *
     * @return ComparisonImage
     */
    public function setPath(string $path) : ComparisonImage{
        $this->path = $path;

        return $this;
    }

    /**
     * @param float $acceptableValue
     *
     * @return ComparisonImage
     */
    public function setAcceptableValue(float $acceptableValue) : ComparisonImage{
        $this->acceptableValue = $acceptableValue;

        return $this;
    }

    /**
     * @param int $maxTryTimes
     *
     * @return ComparisonImage
     */
    public function setMaxTryTimes(int $maxTryTimes) : ComparisonImage{
        $this->maxTryTimes = $maxTryTimes;

        return $this;
    }

    /**
     * @param float $scaleRation
     *
     * @return ComparisonImage
     */
    public function setScaleRation(float $scaleRation) : ComparisonImage{
        $this->scaleRation = $scaleRation;

        return $this;
    }

}