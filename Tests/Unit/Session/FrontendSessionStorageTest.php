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

use PHPUnit_Framework_MockObject_MockObject;
use Ssch\T3Session\Session\FrontendSessionStorage;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

class FrontendSessionStorageTest extends AbstractSessionStorageTestCase
{

    /**
     * @var FrontendSessionStorage|PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * @var FrontendUserAuthentication|PHPUnit_Framework_MockObject_MockObject
     */
    protected $user;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->user = $this->getMockBuilder(FrontendUserAuthentication::class)->getMock();
        $this->subject = $this->getMockBuilder(FrontendSessionStorage::class)->setMethods(['getUser'])->getMock();
        $this->subject->expects($this->any())->method('getUser')->willReturn($this->user);
    }

    /**
     * @test
     * @dataProvider getDataForHas
     */
    public function hasKeyReturnsTrue($key, $value)
    {
        $this->user->expects($this->any())->method('getKey')->willReturn($value);
        $this->assertTrue($this->subject->has($key, 'ses'));
    }

    /**
     * @param $key
     * @param $value
     * @test
     * @dataProvider getDataForRead
     */
    public function readReturnsCorrectValue($key, $value, $expected)
    {
        $this->user->expects($this->any())->method('getKey')->willReturn($value);
        $this->assertEquals($expected, $this->subject->read($key));
    }
}
