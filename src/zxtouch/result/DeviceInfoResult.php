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


class DeviceInfoResult extends Result{

    private string $name;
    private string $systemName;
    private string $systemVersion;
    private string $model;
    private string $identifierForVendor;

    public function __construct(bool $result, string $errorMessage, string $name, string $systemName, string $systemVersion, string $model, string $identifierForVendor){
        parent::__construct($result, $errorMessage);

        $this->name = $name;
        $this->systemName = $systemName;
        $this->systemVersion = $systemVersion;
        $this->model = $model;
        $this->identifierForVendor = $identifierForVendor;
    }

    /**
     * @return string
     */
    public function getName() : string{
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSystemName() : string{
        return $this->systemName;
    }

    /**
     * @return string
     */
    public function getSystemVersion() : string{
        return $this->systemVersion;
    }

    /**
     * @return string
     */
    public function getModel() : string{
        return $this->model;
    }

    /**
     * @return string
     */
    public function getIdentifierForVendor() : string{
        return $this->identifierForVendor;
    }

}