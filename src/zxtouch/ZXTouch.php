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


use zxtouch\element\AlertInfo;
use zxtouch\element\ColorRange;
use zxtouch\element\ComparisonImage;
use zxtouch\element\Coordinates;
use zxtouch\element\OCR;
use zxtouch\element\Region;
use zxtouch\element\Text;
use zxtouch\element\toast\Toast;
use zxtouch\element\touch\Touch;
use zxtouch\element\touch\TouchDown;
use zxtouch\element\touch\TouchUp;
use zxtouch\element\value\IntegerValue;
use zxtouch\element\value\StringValue;
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
use zxtouch\utils\Connection;
use zxtouch\utils\DeviceInfoIds;
use zxtouch\utils\KeyboardIds;
use zxtouch\utils\OCRIds;
use zxtouch\utils\TaskIds;


class ZXTouch{

    private Connection $connection;

    public function __construct(string $ip, int $port = 6000){
        $this->connection = new Connection($ip, $port);
    }

    /**
     * Returns a Connection instance to get socket, ip, and port
     *
     * @return Connection
     */
    public function getConnection() : Connection{
        return $this->connection;
    }

    /**
     * I think this is useless for PHP...
     *
     * @param IntegerValue $microsecond
     *
     * @return DefaultResult
     */
    public function accurateUsleep(IntegerValue $microsecond) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::USLEEP);
        $encoder->addParameter((string) $microsecond->getValue());

        $this->send($encoder);

        return $this->read()->getDefaultResult();
    }

    /**
     * Run shell command on device as root
     *
     * @param StringValue $command
     *
     * @return DefaultResult
     */
    public function executeShell(StringValue $command) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::RUN_SHELL);
        $encoder->addParameter($command->getValue());

        $this->send($encoder);

        return $this->read()->getDefaultResult();
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

        return $this->read()->getBatteryInfoResult();
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

        return $this->read()->getTextResult();
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

        return $this->read()->getDeviceInfoResult();
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

        return $this->read()->getIntegerResult();
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

        return $this->read()->getIntegerResult();
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

        return $this->read()->getScreenSizeResult();
    }

    /**
     * Get languages that can be recognized by OCR
     *
     * @param IntegerValue $recognitionLevel A value that determines whether the request prioritizes accuracy or speed in text recognition. 0 means accurate. 1 means faster.
     *
     * @return OCRSupportedLanguagesResult
     */
    public function getSupportedOCRLanguages(IntegerValue $recognitionLevel) : OCRSupportedLanguagesResult{
        $encoder = new BufferEncoder(TaskIds::TEXT_RECOGNIZER);
        $encoder->addParameter((string) OCRIds::GET_SUPPORTED_LANGUAGES);
        $encoder->addParameter((string) $recognitionLevel->getValue());

        $this->send($encoder);

        return $this->read()->getOCRSupportedLanguagesResult();
    }

    /**
     * Hide the keyboard
     *
     * @return DefaultResult
     */
    public function hideKeyboard() : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::VIRTUAL_KEYBOARD);
        $encoder->addParameter((string) KeyboardIds::HIDE_KEYBOARD);

        $this->send($encoder);

        return $this->read()->getDefaultResult();
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
            }elseif(is_string($character)){
                $encoder->addParameter((string) KeyboardIds::INSERT_TEXT);
                $encoder->addParameter($character);
            }

            $this->send($encoder);
            $this->read();
        }
    }

    /**
     * Get text from a region
     *
     * @param Region               $region
     * @param OCR                  $ocr
     *
     * @return OCRResult
     */
    public function ocr(Region $region, OCR $ocr) : OCRResult{
        $encoder = new BufferEncoder(TaskIds::TEXT_RECOGNIZER);
        $encoder->addParameter((string) OCRIds::RECOGNIZE_TEXT);
        $encoder->addParameter($region->toOCR());
        $encoder->addParameter($ocr->getConvertedWords());
        $encoder->addParameter((string) $ocr->getMinimumHeight());
        $encoder->addParameter((string) $ocr->getRecognitionLevel());
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

        return $this->read()->getMatchingImageResult();
    }

    /**
     * Move the cursor on the text field
     *
     * @param IntegerValue $offset
     *
     * @return DefaultResult
     */
    public function moveCursor(IntegerValue $offset) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::KEYBOARDIMPL);
        $encoder->addParameter((string) KeyboardIds::MOVE_CURSOR);
        $encoder->addParameter((string) $offset->getValue());

        $this->send($encoder);

        return $this->read()->getDefaultResult();
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

        return $this->read()->getDefaultResult();
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

        return $this->read()->getPickedColorResult();
    }

    /**
     * Play a script
     *
     * @param StringValue $path
     *
     * @return DefaultResult
     */
    public function playScript(StringValue $path) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::PLAY_SCRIPT);
        $encoder->addParameter($path->getValue());

        $this->send($encoder);

        return $this->read()->getDefaultResult();
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

        return $this->read()->getSearchedColorResult();
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

        return $this->read()->getDefaultResult();
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

        return $this->read()->getDefaultResult();
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

        return $this->read()->getDefaultResult();
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

        return $this->read()->getDefaultResult();
    }

    /**
     * Start recording touch events
     *
     * @return DefaultResult
     */
    public function startTouchRecording() : DefaultResult{
        $this->send(new BufferEncoder(TaskIds::TOUCH_RECORDING_START));

        return $this->read()->getDefaultResult();
    }

    /**
     * Stop playing current script
     *
     * @return DefaultResult
     */
    public function stopScriptPlaying() : DefaultResult{
        $this->send(new BufferEncoder(TaskIds::PLAY_SCRIPT_FORCE_STOP));

        return $this->read()->getDefaultResult();
    }

    /**
     * Start recording touch events
     *
     * @return DefaultResult
     */
    public function stopTouchRecording() : DefaultResult{
        $this->send(new BufferEncoder(TaskIds::TOUCH_RECORDING_STOP));

        return $this->read()->getDefaultResult();
    }

    /**
     * Bring an application to foreground
     *
     * @param StringValue $identifier This value must be an identifier of application
     *
     * @return DefaultResult
     */
    public function switchApp(StringValue $identifier) : DefaultResult{
        $encoder = new BufferEncoder(TaskIds::PROCESS_BRING_FOREGROUND);
        $encoder->addParameter($identifier->getValue());

        $this->send($encoder);

        return $this->read()->getDefaultResult();
    }

    /**
     * Perform a single tap on screen
     *
     * @param Coordinates $coordinates
     * @param int         $fingerIndex
     *
     * @throws ZXTouchException
     */
    public function tap(Coordinates $coordinates, int $fingerIndex = 1) : void{
        $this->touch(new TouchDown($fingerIndex, $coordinates));
        usleep(80000);
        $this->touch(new TouchUp($fingerIndex, $coordinates));
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
     * @internal
     */
    private function send(BufferEncoder $encoder) : void{
        $buffer = $encoder->getBuffer();

        socket_send($this->connection->getSocket(), $buffer, strlen($buffer), MSG_DONTROUTE);
    }

    /**
     * @internal
     */
    private function read(int $length = 1024) : BufferDecoder{
        socket_recv($this->connection->getSocket(), $buffer, $length, 0);

        return new BufferDecoder($buffer);
    }

}