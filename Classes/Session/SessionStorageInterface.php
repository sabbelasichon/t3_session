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
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

interface SessionStorageInterface extends SingletonInterface
{

    /**
     * @param mixed $data
     * @return bool
     */
    public function isSerializable($data);

    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function isSerialized($data);

    /**
     * @param string $key
     * @param string $type
     */
    public function read($key, $type = '');

    /**
     * @param string $key
     * @param mixed $data
     * @param string $type
     */
    public function write($key, $data, $type = '');

    /**
     * @param string $key
     * @param string $type
     */
    public function remove($key, $type = '');

    /**
     * @param string $key
     * @param string $type
     * @return bool
     */
    public function has($key, $type = '');

    /**
     * @return BackendUserAuthentication|FrontendUserAuthentication
     */
    public function getUser();

    /**
     * @return string
     */
    public function getName();
}
