<?php

/*
 * This file is part of ZXTouch-PHP.
 *
 * (c) AquaChocomint
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace zxtouch\utils;


class BufferEncoder{

    private string $buffer = '';
    private bool $encoded = false;
    /** @var string[] */
    private array $parameters = [];
    private string $taskId;

    public function __construct(int $taskId){
        $this->taskId = (string) $taskId;
    }

    /**
     * Return encoded buffer
     *
     * @return string
     */
    public function getBuffer() : string{
        if(!$this->encoded){
            $this->encode();
        }

        return $this->buffer;
    }

    /**
     * @param string $param
     */
    public function addParameter(string $param) : void{
        $this->parameters[] = $param;
    }

    public function deleteParameters() : void{
        $this->parameters = [];
    }

    /**
     * @return string[]
     */
    public function getParameters() : array{
        return $this->parameters;
    }

    /**
     * Encode a buffer to tweak-readable
     */
    public function encode() : void{
        $this->buffer = $this->taskId . implode(';;', $this->parameters) . "\r\n";
    }

}