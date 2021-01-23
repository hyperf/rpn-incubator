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

use Hyperf\Rpn\Exception\InvalidExpressionException;
use Hyperf\Rpn\Exception\InvalidOperatorException;
use Hyperf\Rpn\Exception\InvalidValueException;
use Hyperf\Rpn\Exception\NotFoundException;
use Hyperf\Rpn\Operator\AddOperator;
use Hyperf\Rpn\Operator\DivideOperator;
use Hyperf\Rpn\Operator\HasBindings;
use Hyperf\Rpn\Operator\MultiplyOperator;
use Hyperf\Rpn\Operator\OperatorInterface;
use Hyperf\Rpn\Operator\SubtractOperator;

class Calculator
{
    use HasBindings;

    /**
     * @var string
     */
    protected $leftTag = '(';

    /**
     * @var string
     */
    protected $rightTag = ')';

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

    public function calculate(string $expression, array $bindings = [], int $scale = 0): string
    {
        $queue = new \SplQueue();
        $tags = $this->fromBindings(explode(' ', $expression), $bindings);
        foreach ($tags as $tag) {
            if (! $this->isOperator($tag)) {
                $queue->push($tag);
                continue;
            }

            $operator = $this->getOperator($tag);

            $params = [];
            $length = $operator->length();
            while (true) {
                $value = $queue->pop();
                if (! is_numeric($value)) {
                    throw new InvalidValueException(sprintf('The value %s is invalid.', $value));
                }
                $params[] = $value;
                --$length;
                if ($length <= 0) {
                    break;
                }
            }

            $queue->push($operator->execute(array_reverse($params), $scale));
        }

        if ($queue->count() !== 1) {
            throw new InvalidExpressionException(sprintf('The expression %s is invalid.', $expression));
        }

        return $queue->pop();
    }

    public function toRPNExpression(string $expression): string
    {
        $tags = explode(' ', $expression);
        foreach ($tags as $tag) {
            if ($this->isOperator($tag)) {
            }
        }

        return '';
    }

    protected function getOperator(string $tag): OperatorInterface
    {
        $operator = $this->operators[$tag] ?? null;
        if (! $operator instanceof OperatorInterface) {
            throw new NotFoundException(sprintf('Operator %s is not found.', $tag));
        }

        return $operator;
    }

    protected function isOperator(string $tag): bool
    {
        return array_key_exists($tag, $this->operators);
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
