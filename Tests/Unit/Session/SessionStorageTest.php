<?php

namespace Ssch\T3Session\Tests\Unit\Session;

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

use Ssch\T3Session\Session\SessionStorage;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Service\EnvironmentService;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use Ssch\T3Session\Session\FrontendSessionStorage;
use Ssch\T3Session\Session\BackendSessionStorage;
use PHPUnit_Framework_MockObject_MockObject;

class SessionStorageTest extends UnitTestCase
{

    /**
     * @var SessionStorage
     */
    protected $subject;

    /**
     * @var EnvironmentService|PHPUnit_Framework_MockObject_MockObject
     */
    protected $environmentService;

    /**
     * @var ObjectManagerInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->environmentService = $this->getMockBuilder(EnvironmentService::class)->getMock();
        $this->objectManager = $this->getMockBuilder(ObjectManagerInterface::class)->getMock();
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function throwsExceptionDueToWrongEnvironment()
    {
        $this->environmentService->expects($this->once())->method('isEnvironmentInFrontendMode')->willReturn(false);
        $this->environmentService->expects($this->once())->method('isEnvironmentInBackendMode')->willReturn(false);

        $object = new SessionStorage($this->objectManager, $this->environmentService);
    }

    /**
     * @test
     */
    public function createFrontendSessionStorage()
    {
        $this->environmentService->expects($this->once())->method('isEnvironmentInFrontendMode')->willReturn(true);
        $this->objectManager->expects($this->once())->method('get')->with(FrontendSessionStorage::class);

        $object = new SessionStorage($this->objectManager, $this->environmentService);
    }

    /**
     * @test
     */
    public function createBackendSessionStorage()
    {
        $this->environmentService->expects($this->once())->method('isEnvironmentInFrontendMode')->willReturn(false);
        $this->environmentService->expects($this->once())->method('isEnvironmentInBackendMode')->willReturn(true);
        $this->objectManager->expects($this->once())->method('get')->with(BackendSessionStorage::class);

        $object = new SessionStorage($this->objectManager, $this->environmentService);
    }

}
