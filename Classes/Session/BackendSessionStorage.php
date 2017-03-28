<?php

namespace Ssch\T3Session\Session;

/*
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

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

class BackendSessionStorage extends AbstractSessionStorage
{

    /**
     * @param string $key
     * @param string $type
     *
     * @return mixed
     */
    public function read($key, $type = '')
    {
        $data = $this->getUser()->getSessionData($this->getKey($key));
        return $this->isSerialized($data) ? unserialize($data) : $data;
    }

    /**
     * @param string $key
     * @param mixed $data
     * @param string $type
     */
    public function write($key, $data, $type = '')
    {
        $data = $this->isSerializable($data) ? serialize($data) : $data;
        $this->getUser()->setAndSaveSessionData($this->getKey($key), $data);
    }

    /**
     * @param string $key
     * @param string $type
     */
    public function remove($key, $type = '')
    {
        if ($this->has($key)) {
            $this->write($key, '');
        }
    }

    /**
     * @param string $key
     * @param string $type
     *
     * @return bool
     */
    public function has($key, $type = 'ses_data')
    {
        $sesDat = unserialize($this->getUser()->user[$type]);
        return isset($sesDat[$this->getKey($key)]);
    }

    /**
     *
     * @return BackendUserAuthentication
     */
    public function getUser()
    {
        return $GLOBALS['BE_USER'];
    }
}
