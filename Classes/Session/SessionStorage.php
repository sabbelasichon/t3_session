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


use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Service\EnvironmentService;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use BadMethodCallException;

class SessionStorage implements SessionStorageInterface
{

    /**
     *
     * @var SessionStorageInterface
     */
    protected $sessionStorage;

    /**
     *
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var EnvironmentService
     */
    protected $environmentService;

    /**
     * SessionStorage constructor.
     *
     * @param ObjectManagerInterface $objectManager
     * @param EnvironmentService $environmentService
     */
    public function __construct(ObjectManagerInterface $objectManager, EnvironmentService $environmentService)
    {
        $this->objectManager      = $objectManager;
        $this->environmentService = $environmentService;
        $this->initializeConcreteSessionManager();
    }

    /**
     * Initialize the concrete session manager
     */
    protected function initializeConcreteSessionManager()
    {
        if ($this->environmentService->isEnvironmentInFrontendMode()) {
            $this->sessionStorage = $this->objectManager->get(FrontendSessionStorage::class);
        } elseif($this->environmentService->isEnvironmentInBackendMode()) {
            $this->sessionStorage = $this->objectManager->get(BackendSessionStorage::class);
        } else {
            throw new BadMethodCallException('Only available in FE- or BE-Context.');
        }
    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function isSerializable($data)
    {
        return $this->sessionStorage->isSerializable($data);
    }

    /**
     * @param string $key
     * @param string $type
     *
     * @return mixed
     */
    public function read($key, $type = 'ses')
    {
        return $this->sessionStorage->read($key, $type);
    }

    /**
     * Write data to session
     *
     * @param string $key
     * @param mixed $data
     * @param string $type
     */
    public function write($key, $data, $type = 'ses')
    {
        $this->sessionStorage->write($key, $data, $type);
    }

    /**
     * @param string $key
     * @param string $type
     *
     * @return bool
     */
    public function has($key, $type = 'ses')
    {
        return $this->sessionStorage->has($key, $type);
    }

    /**
     * @param string $key
     * @param string $type
     */
    public function remove($key, $type = 'ses')
    {
        $this->sessionStorage->remove($key, $type);
    }

    /**
     *
     * @return FrontendUserAuthentication|BackendUserAuthentication
     */
    public function getUser()
    {
        return $this->sessionStorage->getUser();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->sessionStorage->getUser()->name;
    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function isSerialized($data)
    {
        return $this->sessionStorage->isSerialized($data);
    }


}
