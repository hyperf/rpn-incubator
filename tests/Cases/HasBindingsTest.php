<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Rpn\Cases;

use HyperfTest\Rpn\Stub\HasBindingsStub;

/**
 * @internal
 * @coversNothing
 */
class HasBindingsTest extends AbstractTestCase
{
    public function testGetValue()
    {
        $stub = new HasBindingsStub();
        $this->assertSame(1, $stub->getValue('[1]'));
        $this->assertSame(12, $stub->getValue('[12]'));
        $this->assertSame(999, $stub->getValue('[999]'));
    }
}
