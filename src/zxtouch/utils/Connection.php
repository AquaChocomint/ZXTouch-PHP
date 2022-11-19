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

namespace zxtouch\utils;


use Socket;


class Connection{

    private Socket $socket;

    public function __construct(
        private string $ip,
        private int $port
    ){
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
        socket_connect($this->socket, $this->ip, $this->port);
    }

    /**
     * @return Socket
     */
    public function getSocket() : Socket{
        return $this->socket;
    }

    /**
     * @return string
     */
    public function getIp() : string{
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getPort() : int{
        return $this->port;
    }

    /**
     * Disconnect socket
     */
    public function disconnect() : void{
        socket_close($this->socket);
    }

}