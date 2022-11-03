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


interface TaskIds{
    
    public const PERFORM_TOUCH = 10;
    public const PROCESS_BRING_FOREGROUND = 11;
    public const SHOW_ALERT_BOX = 12;
    public const RUN_SHELL = 13;
    public const TOUCH_RECORDING_START = 14;
    public const TOUCH_RECORDING_STOP = 15;
    public const CRAZY_TAP = 16;
    public const DEPRICATED = 17;
    public const USLEEP = 18;
    public const PLAY_SCRIPT = 19;
    public const PLAY_SCRIPT_FORCE_STOP = 20;
    public const TEMPLATE_MATCH = 21;
    public const SHOW_TOAST = 22;
    public const COLOR_PICKER = 23;
    public const KEYBOARDIMPL = 24;
    public const GET_DEVICE_INFO = 25;
    public const TOUCH_INDICATOR = 26;
    public const TEXT_RECOGNIZER = 27;
    public const COLOR_SEARCHER = 28;

}