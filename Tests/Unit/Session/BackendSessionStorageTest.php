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

use Ssch\T3Session\Session\BackendSessionStorage;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use PHPUnit_Framework_MockObject_MockObject;

class BackendSessionStorageTest extends AbstractSessionStorageTestCase
{

    /**
     * @var BackendSessionStorage|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * @var BackendUserAuthentication|PHPUnit_Framework_MockObject_MockObject
     */
    protected $user;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->user = $this->getMockBuilder(BackendUserAuthentication::class)->getMock();
        $this->subject = $this->getMockBuilder(BackendSessionStorage::class)->setMethods(['getUser'])->getMock();
        $this->subject->expects($this->any())->method('getUser')->willReturn($this->user);
    }

    /**
     * @test
     * @dataProvider getDataForHas
     */
    public function hasKeyReturnsTrue($key, $value)
    {
        $this->user->expects($this->any())->method('getKey')->willReturn($key);
        $this->user->user['ses_data'] = serialize([$key => $value]);
        $this->assertTrue($this->subject->has($key));
    }

    /**
     * @param $key
     * @param $value
     * @test
     * @dataProvider getDataForRead
     */
    public function readReturnsCorrectValue($key, $value, $expected)
    {
        $this->user->expects($this->any())->method('getKey')->willReturn($key);
        $this->user->expects($this->any())->method('getSessionData')->willReturn($value);
        $this->assertEquals($expected, $this->subject->read($key));
    }

}
