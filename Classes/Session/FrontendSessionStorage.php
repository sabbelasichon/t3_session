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
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class FrontendSessionStorage extends AbstractSessionStorage
{

    /**
     * @param string $key
     * @param string $type "type" is either "user" or "ses", which defines the data-space, user- data or session-data
     *
     * @return string
     */
    public function read($key, $type = 'ses')
    {
        return $this->has($key, $type) ? $this->getSessionData($key, $type) : '';
    }

    /**
     * @param string $key
     * @param string $type "type" is either "user" or "ses", which defines the data-space, user- data or session-data
     *
     * @return bool
     */
    public function has($key, $type = 'ses')
    {
        return $this->getSessionData($key, $type) !== '';
    }

    /**
     * @param string $key
     * @param mixed $data
     * @param string $type "type" is either "user" or "ses", which defines the data-space, user- data or session-data
     */
    public function write($key, $data = null, $type = 'ses')
    {
        $data = $this->isSerializable($data) ? serialize($data) : $data;
        $this->getUser()->setKey($type, $this->getKey($key), $data);
        $this->getUser()->storeSessionData();
    }

    /**
     * @param string $key
     * @param string $type "type" is either "user" or "ses", which defines the data-space, user- data or session-data
     */
    public function remove($key, $type = 'ses')
    {
        if ($this->has($key, $type)) {
            $this->write($key, null, $type);
        }
    }

    /**
     *
     * @return FrontendUserAuthentication
     */
    public function getUser()
    {
        return $GLOBALS['TSFE']->fe_user;
    }

    /**
     * @param string $key
     * @param string $type "type" is either "user" or "ses", which defines the data-space, user- data or session-data
     *
     * @return mixed
     */
    private function getSessionData($key, $type = 'ses')
    {
        $data = $this->getUser()->getKey($type, $this->getKey($key));
        return $this->isSerialized($data) ? unserialize($data) : $data;
    }
}
