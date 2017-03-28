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

use TYPO3\CMS\Core\Tests\UnitTestCase;

abstract class AbstractSessionStorageTestCase extends UnitTestCase
{

    /**
     * @return array
     */
    public function getDataForRead()
    {
        $object = new \stdClass();
        $object->key = 'value';

        $array = ['key' => 'value'];

        return [
            ['key', 'value', 'value'],
            ['key', serialize($object), $object],
            ['key', serialize($array), $array],
        ];
    }

    /**
     * @return array
     */
    public function getDataForHas()
    {
        $object = new \stdClass();
        $object->key = 'value';

        $array = ['key' => 'value'];

        return [
            ['key', 'value'],
            ['key', $object],
            ['key', $array],
        ];
    }
}
