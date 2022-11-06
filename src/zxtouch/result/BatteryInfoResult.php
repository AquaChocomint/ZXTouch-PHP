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


class BatteryInfoResult extends Result{

    private int $status;
    private int $level;

    public function __construct(bool $result, string $errorMessage, int $status, int $level){
        parent::__construct($result, $errorMessage);

        $this->status = $status;
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getStatus() : int{
        return $this->status;
    }

    /**
     * Returns a battery level
     *
     * @return int
     */
    public function getLevel() : int{
        return $this->level;
    }

    /**
     * Return a battery status as text
     *
     * @return string
     */
    public function getStatusText() : string{
        return match ($this->status) {
            1 => 'Unplugged',
            2 => 'Charging',
            3 => 'Full',
            default => 'Unknown'
        };
    }

}