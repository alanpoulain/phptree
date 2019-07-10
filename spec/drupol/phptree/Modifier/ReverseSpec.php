<?php

declare(strict_types = 1);

namespace spec\drupol\phptree\Modifier;

use drupol\phptree\Modifier\Reverse;
use drupol\phptree\Node\ValueNode;
use PhpSpec\ObjectBehavior;

class ReverseSpec extends ObjectBehavior
{
    public function it_can_reverse_a_tree(): void
    {
        $tree1 = new ValueNode('root');

        $nodes = [];

        foreach (\range('A', 'E') as $value) {
            $nodes[] = new ValueNode($value);
        }
        $tree1->add(...$nodes);

        $tree2 = new ValueNode('root');
        $tree2->add(...\array_reverse($nodes));

        $this
            ->modify($tree1)
            ->count()
            ->shouldReturn(5);

        $this->modify($tree1)->shouldNotBeEqualTo($tree2);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Reverse::class);
    }
}
