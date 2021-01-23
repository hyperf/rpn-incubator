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
namespace Hyperf\Rpn;

use Hyperf\Rpn\Exception\InvalidOperatorException;
use Hyperf\Rpn\Operator\AddOperator;
use Hyperf\Rpn\Operator\DivideOperator;
use Hyperf\Rpn\Operator\MultiplyOperator;
use Hyperf\Rpn\Operator\OperatorInterface;
use Hyperf\Rpn\Operator\SubtractOperator;

class Calculator
{
    /**
     * @var string
     */
    protected $leftTag = '[';

    /**
     * @var string
     */
    protected $rightTag = ']';

    protected $operators = [
    ];

    /**
     * @param OperatorInterface[] $operators
     */
    public function __construct(array $operators = [])
    {
        $operators = array_merge($this->getDefaultOperators(), $operators);
        foreach ($operators as $operator) {
            if (! $operator instanceof OperatorInterface) {
                throw new InvalidOperatorException('%s is not instanceof %s.', get_class($operator), OperatorInterface::class);
            }
            $this->operators[$operator->getOperator()] = $operator;
        }
    }

    public function calculate(string $expression, array $bindings = []): string
    {
    }

    public function toRPNExpression(string $expression): array
    {
        return explode(' ', $expression);
    }

    protected function getDefaultOperators(): array
    {
        return [
            new AddOperator(),
            new SubtractOperator(),
            new MultiplyOperator(),
            new DivideOperator(),
        ];
    }
}
