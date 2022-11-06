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


class Offset{

    /**
     * The related position you want to move. To move left, offset should be negative. For moving right, it should be positive.
     *
     * @param int $offset
     */
    public function __construct(
        private int $offset
    ){
    }

    /**
     * @return int
     */
    public function getOffset() : int{
        return $this->offset;
    }

}