<?php

declare(strict_types=1);

namespace drupol\phptree\Builder;

use drupol\phptree\Node\NodeInterface;

use function is_callable;

/**
 * Class Random.
 */
class Random implements BuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(iterable $nodes): ?NodeInterface
    {
        $root = null;

        foreach ($nodes as $key => $value) {
            if (0 === $key) {
                $root = self::createNode($value);

                continue;
            }

            if (false === ($root instanceof NodeInterface)) {
                continue;
            }

            self::pickRandomNode($root)->add(self::createNode($value));
        }

        return $root;
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return \drupol\phptree\Node\NodeInterface
     */
    private static function createNode(array $parameters = []): NodeInterface
    {
        $parameters = array_map(
            static function ($parameter) {
                if (is_callable($parameter)) {
                    return $parameter();
                }

                return $parameter;
            },
            $parameters
        );

        $class = array_shift($parameters);

        return new $class(...$parameters);
    }

    /**
     * @param \drupol\phptree\Node\NodeInterface $node
     *
     * @return \drupol\phptree\Node\NodeInterface
     */
    private static function pickRandomNode(NodeInterface $node): NodeInterface
    {
        $pick = (int) random_int(0, $node->count());

        $i = 0;

        foreach ($node->all() as $child) {
            if (++$i === $pick) {
                return $child;
            }
        }

        return $node;
    }
}