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
namespace HyperfTest\Cases;

use Hyperf\Rpn\Calculator;
use Hyperf\Rpn\Exception\InvalidOperatorException;

/**
 * @internal
 * @coversNothing
 */
class CalculatorTest extends AbstractTestCase
{
    // public function testToRPNExpression()
    // {
    //     $calculator = new Calculator();
    //     $expression = $calculator->toRPNExpression('1 + 1');
    // }

    public function testCalculateAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->calculate('1 1 +');
        $this->assertSame('2', $result);
    }

    public function testInvalidOperator()
    {
        $this->expectExceptionMessage(InvalidOperatorException::class);

        new Calculator([new \StdClass()]);
    }
}
