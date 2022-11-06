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


class DefaultResult extends Result{

    private ?string $message;

    public function __construct(bool $result, string $errorMessage, string $message){
        parent::__construct($result, $errorMessage);

        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage() : string{
        return $this->message;
    }

}