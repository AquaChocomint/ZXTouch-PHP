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

namespace zxtouch;


use Socket;
use zxtouch\element\AbsolutePath;
use zxtouch\element\AlertInfo;
use zxtouch\element\AppIdentifier;
use zxtouch\element\ColorRange;
use zxtouch\element\ComparisonImage;
use zxtouch\element\Coordinates;
use zxtouch\element\Microsecond;
use zxtouch\element\OCR;
use zxtouch\element\Offset;
use zxtouch\element\Region;
use zxtouch\element\ShellCommand;
use zxtouch\element\Text;
use zxtouch\element\TextRecognitionLevel;
use zxtouch\element\toast\Toast;
use zxtouch\element\touch\Touch;
use zxtouch\result\BatteryInfoResult;
use zxtouch\result\DefaultResult;
use zxtouch\result\DeviceInfoResult;
use zxtouch\result\IntegerResult;
use zxtouch\result\MatchingImageResult;
use zxtouch\result\ocr\OCRResult;
use zxtouch\result\ocr\OCRSupportedLanguagesResult;
use zxtouch\result\PickedColorResult;
use zxtouch\result\ScreenSizeResult;
use zxtouch\result\SearchedColorResult;
use zxtouch\result\TextResult;
use zxtouch\utils\BufferDecoder;
use zxtouch\utils\BufferEncoder;
use zxtouch\utils\ColorSearchIds;
use zxtouch\utils\DeviceInfoIds;
use zxtouch\utils\KeyboardIds;
use zxtouch\utils\OCRIds;
use zxtouch\utils\TaskIds;


class ZXTouch{

    private Socket $socket;

    public function __construct(
        private string $ip,
        private int $port = 6000
    ){
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
        socket_connect($this->socket, $this->ip, $this->port);
    }

    /**
     * I think this is useless for PHP...
     *
     * @param Microsecond $microsecond
     *
     * @return DefaultResult
     */
    public function accurateUsleep(Microsecond $microsecond) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::USLEEP);
        $encoder->addParameter((string) $microsecond->getMicrosecond());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Run shell command on device as root
     *
     * @param ShellCommand $command
     *
     * @return DefaultResult
     */
    public function executeShell(ShellCommand $command) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::RUN_SHELL);
        $encoder->addParameter($command->getCommand());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Get the battery status
     *
     * @return BatteryInfoResult
     */
    public function getBatteryInfo() : BatteryInfoResult{
        $encoder = new BufferEncoder(TaskIds::GET_DEVICE_INFO);
        $encoder->addParameter((string) DeviceInfoIds::BATTERY_INFO);

        $this->send($encoder);

        return $this->read(1024)->getBatteryInfoResult();
    }

    /**
     * Get text from clip board
     *
     * @return TextResult
     */
    public function getClipboard() : TextResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::GET_CLIPBOARD);

        $this->send($encoder);

        return $this->read(1024)->getTextResult();
    }

    /**
     * Get information of the device
     *
     * @return DeviceInfoResult
     */
    public function getDeviceInfo() : DeviceInfoResult{
        $encoder = new BufferEncoder(TaskIds::GET_DEVICE_INFO);
        $encoder->addParameter((string) DeviceInfoIds::DEVICE_INFO);

        $this->send($encoder);

        return $this->read(1024)->getDeviceInfoResult();
    }

    /**
     * Get orientation of the screen
     *
     * @return IntegerResult
     */
    public function getScreenOrientation() : IntegerResult{
        $encoder = new BufferEncoder(TaskIds::GET_DEVICE_INFO);
        $encoder->addParameter((string) DeviceInfoIds::SCREEN_ORIENTATION);

        $this->send($encoder);

        return $this->read(1024)->getIntegerResult();
    }

    /**
     * Get scale of the screen
     *
     * @return IntegerResult
     */
    public function getScreenScale() : IntegerResult{
        $encoder = new BufferEncoder(TaskIds::GET_DEVICE_INFO);
        $encoder->addParameter((string) DeviceInfoIds::SCREEN_SCALE);

        $this->send($encoder);

        return $this->read(1024)->getIntegerResult();
    }

    /**
     * Get screen size in pixels
     *
     * @return ScreenSizeResult
     */
    public function getScreenSize() : ScreenSizeResult{
        $encoder = new BufferEncoder(TaskIds::GET_DEVICE_INFO);
        $encoder->addParameter((string) DeviceInfoIds::SCREEN_SIZE);

        $this->send($encoder);

        return $this->read(1024)->getScreenSizeResult();
    }

    /**
     * Get languages that can be recognized by OCR
     *
     * @param TextRecognitionLevel $recognitionLevel
     *
     * @return OCRSupportedLanguagesResult
     */
    public function getSupportedOCRLanguages(TextRecognitionLevel $recognitionLevel) : OCRSupportedLanguagesResult{
        $encoder = new BufferEncoder(TaskIds::TEXT_RECOGNIZER);
        $encoder->addParameter((string) OCRIds::GET_SUPPORTED_LANGUAGES);
        $encoder->addParameter((string) $recognitionLevel->getRecognitionLevel());

        $this->send($encoder);

        return $this->read(1024)->getOCRSupportedLanguagesResult();
    }

    /**
     * Hide the keyboard
     *
     * @return DefaultResult
     */
    public function hideKeyboard() : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::VIRTUAL_KEYBOARD);
        $encoder->addParameter((string) KeyboardIds::SHOW_KEYBOARD);

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Insert text into the text field
     *
     * @param Text $text
     */
    public function insertText(Text $text) : void{
        $characters = mb_str_split($text->getText());
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);

        for($i = 0, $character = current($characters); $i < count($characters); ++$i){
            $encoder->deleteParameters();

            if($i > 0){
                $character = next($characters);
            }

            if($character === '\\'){
                $next = next($characters);
                if($next === 'b'){
                    $encoder->addParameter((string) KeyboardIds::DELETE_CHARACTERS);
                    $encoder->addParameter('1');
                }else{
                    prev($characters);
                }
            }else{
                $encoder->addParameter((string) KeyboardIds::INSERT_TEXT);
                $encoder->addParameter($character);
            }

            $this->send($encoder);
            $this->read(1024);
        }
    }

    /**
     * Get text from a region
     *
     * @param Region               $region
     * @param OCR                  $ocr
     * @param TextRecognitionLevel $recognitionLevel
     *
     * @return OCRResult
     */
    public function ocr(Region $region, OCR $ocr, TextRecognitionLevel $recognitionLevel) : OCRResult{
        $encoder = new BufferEncoder(TaskIds::TEXT_RECOGNIZER);
        $encoder->addParameter((string) OCRIds::GET_SUPPORTED_LANGUAGES);
        $encoder->addParameter($region->toOCR());
        $encoder->addParameter($ocr->getConvertedWords());
        $encoder->addParameter((string) $ocr->getMinimumHeight());
        $encoder->addParameter((string) $recognitionLevel->getRecognitionLevel());
        $encoder->addParameter($ocr->getConvertedLanguages());
        $encoder->addParameter((string) $ocr->getAutoCorrect());
        $encoder->addParameter($ocr->getDebugImagePath());

        $this->send($encoder);

        return $this->read(2048)->getOCRResult();
    }

    /**
     * Get the coordinate of an image
     *
     * @param ComparisonImage $image
     *
     * @return MatchingImageResult
     */
    public function matchImage(ComparisonImage $image) : MatchingImageResult{
        $encoder = new BufferEncoder(TaskIds::TEMPLATE_MATCH);
        $encoder->addParameter($image->getPath());
        $encoder->addParameter((string) $image->getMaxTryTimes());
        $encoder->addParameter((string) $image->getAcceptableValue());
        $encoder->addParameter((string) $image->getScaleRation());

        $this->send($encoder);

        return $this->read(1024)->getMatchingImageResult();
    }

    /**
     * Move the cursor on the text field
     *
     * @param Offset $offset
     *
     * @return DefaultResult
     */
    public function moveCursor(Offset $offset) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::MOVE_CURSOR);
        $encoder->addParameter((string) $offset->getOffset());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Paste text from clip board
     *
     * @return DefaultResult
     */
    public function pasteClipboard() : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::PASTE_CLIPBOARD);

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Get the rgb value from the screen
     *
     * @param Coordinates $coordinates
     *
     * @return PickedColorResult
     */
    public function pickColor(Coordinates $coordinates) : PickedColorResult{
        $encoder = new BufferEncoder(TaskIds::COLOR_PICKER);
        $encoder->addParameter((string) $coordinates->getX());
        $encoder->addParameter((string) $coordinates->getY());

        $this->send($encoder);

        return $this->read(1024)->getPickedColorResult();
    }

    /**
     * Play a script
     *
     * @param AbsolutePath $path
     *
     * @return DefaultResult
     */
    public function playScript(AbsolutePath $path) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::PLAY_SCRIPT);
        $encoder->addParameter($path->getPath());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * @param Region     $region The region to search
     * @param ColorRange $red The range of red colors to search
     * @param ColorRange $green The range of green colors to search
     * @param ColorRange $blue The range of blue colors to search
     * @param int        $pixelToSkip How many pixel to skip when searching
     *
     * @return SearchedColorResult
     */
    public function searchColor(Region $region, ColorRange $red, ColorRange $green, ColorRange $blue, int $pixelToSkip = 0) : SearchedColorResult{
        $encoder = new BufferEncoder(TaskIds::COLOR_SEARCHER);
        $encoder->addParameter((string) ColorSearchIds::RGB_SINGLE_POINT);
        $encoder->addParameter((string) $region->getX());
        $encoder->addParameter((string) $region->getY());
        $encoder->addParameter((string) $region->getWidth());
        $encoder->addParameter((string) $region->getHeight());
        $encoder->addParameter((string) $red->getColorMin());
        $encoder->addParameter((string) $red->getColorMax());
        $encoder->addParameter((string) $green->getColorMin());
        $encoder->addParameter((string) $green->getColorMax());
        $encoder->addParameter((string) $blue->getColorMin());
        $encoder->addParameter((string) $blue->getColorMax());
        $encoder->addParameter((string) $pixelToSkip);

        $this->send($encoder);

        return $this->read(1024)->getSearchedColorResult();
    }

    /**
     * Show alert box on device
     *
     * @param AlertInfo $alertInfo
     *
     * @return DefaultResult
     */
    public function sendAlertBox(AlertInfo $alertInfo) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::SHOW_ALERT_BOX);
        $encoder->addParameter($alertInfo->getTitle());
        $encoder->addParameter($alertInfo->getContent());
        $encoder->addParameter((string) $alertInfo->getDuration());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Show toast
     *
     * @param Toast $toast
     *
     * @return DefaultResult
     */
    public function sendToast(Toast $toast) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::SHOW_TOAST);
        $encoder->addParameter((string) $toast->getType());
        $encoder->addParameter($toast->getContent());
        $encoder->addParameter((string) $toast->getDuration());
        $encoder->addParameter((string) $toast->getPosition());
        $encoder->addParameter((string) $toast->getFontSize());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Set clipboard text
     *
     * @param Text $text
     *
     * @return DefaultResult
     */
    public function setClipboard(Text $text) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::SET_CLIPBOARD);
        $encoder->addParameter($text->getText());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Show the keyboard
     *
     * @return DefaultResult
     */
    public function showKeyboard() : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::VIRTUAL_KEYBOARD);
        $encoder->addParameter((string) KeyboardIds::SHOW_KEYBOARD);

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Start recording touch events
     *
     * @return DefaultResult
     */
    public function startTouchRecording() : DefaultResult{
        $this->send(new BufferEncoder(TaskIds::TOUCH_RECORDING_START));

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Stop playing current script
     *
     * @return DefaultResult
     */
    public function stopScriptPlaying() : DefaultResult{
        $this->send(new BufferEncoder(TaskIds::PLAY_SCRIPT_FORCE_STOP));

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Start recording touch events
     *
     * @return DefaultResult
     */
    public function stopTouchRecording() : DefaultResult{
        $this->send(new BufferEncoder(TaskIds::TOUCH_RECORDING_STOP));

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Bring an application to foreground
     *
     * @param AppIdentifier $identifier
     *
     * @return DefaultResult
     */
    public function switchApp(AppIdentifier $identifier) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::PROCESS_BRING_FOREGROUND);
        $encoder->addParameter($identifier->getIdentifier());

        $this->send($encoder);

        return $this->read(1024)->getDefaultResult();
    }

    /**
     * Perform a touch event
     */
    public function touch(Touch $touch) : void{
        $encoder = new BufferEncoder(TaskIds::PERFORM_TOUCH);
        $encoder->addParameter('1' . $touch->getBuffer());

        $this->send($encoder);
    }

    /**
     * Perform touch events with a list of events
     *
     * @param Touch[] $values
     */
    public function touches(array $values) : void{
        $encoder = new BufferEncoder(TaskIds::PERFORM_TOUCH);
        $str = (string) count($values);
        foreach($values as $touch){
            $str .= $touch->getBuffer();
        }
        $encoder->addParameter($str);

        $this->send($encoder);
    }

    /**
     * Disconnect socket
     */
    public function disconnect() : void{
        socket_close($this->socket);
    }

    /**
     * @internal
     */
    private function send(BufferEncoder $encoder) : void{
        $buffer = $encoder->getBuffer();

        socket_send($this->socket, $buffer, strlen($buffer), MSG_OOB);
    }

    /**
     * @internal
     */
    private function read(int $length) : BufferDecoder{
        socket_recv($this->socket, $buffer, $length, MSG_PEEK);

        return new BufferDecoder($buffer);
    }

}