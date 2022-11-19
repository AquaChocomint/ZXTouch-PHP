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


abstract class Result{

    private bool $result;
    private string $errorMessage;

    public function __construct(bool $result, string $errorMessage){
        $this->result = $result;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return bool
     */
    public function hasResult() : bool{
        return $this->result;
    }

    /**
     * @return string
     */
    public function getErrorMessage() : string{
        return $this->errorMessage;
    }

}