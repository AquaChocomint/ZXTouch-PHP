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


interface KeyboardIds{

    public const INSERT_TEXT = 1;
    public const VIRTUAL_KEYBOARD = 2;
    public const MOVE_CURSOR = 3;
    public const DELETE_CHARACTERS = 4;
    public const PASTE_CLIPBOARD = 5;
    public const GET_CLIPBOARD = 6;
    public const SET_CLIPBOARD = 7;

    public const HIDE_KEYBOARD = 1;
    public const SHOW_KEYBOARD = 2;

}