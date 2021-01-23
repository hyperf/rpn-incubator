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
namespace Hyperf\Rpn\Operator;

class SubtractOperator extends Operator
{
    public function getOperator(): string
    {
        return '-';
    }

    public function execute(array $paramaters, array $bindings): string
    {
        // TODO: Implement execute() method.
    }
}
