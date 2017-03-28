<?php

namespace Ssch\T3Session\Session;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

abstract class AbstractSessionStorage implements SessionStorageInterface
{

    /**
     * @var string
     */
    protected $sessionNamespace;

    /**
     * AbstractSessionStorage constructor.
     *
     * @param string $sessionNamespace
     */
    public function __construct($sessionNamespace = '')
    {
        $this->sessionNamespace = $sessionNamespace;
    }


    /**
     * Check whether the data is serializable or not
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function isSerializable($data = null)
    {
        if (is_object($data) || is_array($data)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function isSerialized($data)
    {
        // if it isn't a string, it isn't serialized
        if ( ! is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        if ( ! preg_match('/^([adObis]):/', $data, $badions)) {
            return false;
        }
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data)) {
                    return true;
                }
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data)) {
                    return true;
                }
                break;
        }

        return false;
    }


    /**
     * @param string $key
     *
     * @return string
     */
    protected function getKey($key)
    {
        return $this->sessionNamespace.$key;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->getUser()->name;
    }

}
