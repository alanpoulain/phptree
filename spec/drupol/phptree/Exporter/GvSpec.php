<?php

declare(strict_types = 1);

namespace spec\drupol\phptree\Exporter;

use drupol\phptree\Exporter\Gv;
use drupol\phptree\Node\AttributeNode;
use drupol\phptree\Node\ValueNode;
use PhpSpec\ObjectBehavior;

class GvSpec extends ObjectBehavior
{
    public function it_can_export_to_dot_gv(): void
    {
        $attributes = [
            'ratio' => 'fill',
            'node' => [
                'style' => 'filled',
            ],
        ];

        $this
            ->setGraphAttributes($attributes);

        $tree = new AttributeNode(['label' => 'root']);
        $child1 = new ValueNode('child1');
        $child2 = new ValueNode('child2');
        $child3 = new ValueNode('child3');
        $child4 = new ValueNode('child4');
        $child1->add($child4);

        $tree
            ->add($child1, $child2, $child3);

        $nodes['root'] = [
            'hash' => \sha1(\spl_object_hash($tree)),
            'value' => 'root',
        ];
        $nodes['child1'] = [
            'hash' => \sha1(\spl_object_hash($child1)),
            'value' => $child1->getValue(),
        ];
        $nodes['child2'] = [
            'hash' => \sha1(\spl_object_hash($child2)),
            'value' => $child2->getValue(),
        ];
        $nodes['child3'] = [
            'hash' => \sha1(\spl_object_hash($child3)),
            'value' => $child3->getValue(),
        ];
        $nodes['child4'] = [
            'hash' => \sha1(\spl_object_hash($child4)),
            'value' => $child4->getValue(),
        ];

        $result = <<<EOF
digraph PHPTreeGraph {
// The graph attributes.
  ratio = fill
  node [style="filled"]

// The graph nodes.
  "{$nodes['root']['hash']}" [label="{$nodes['root']['value']}"]
  "{$nodes['child1']['hash']}" [label="{$nodes['child1']['value']}"]
  "{$nodes['child4']['hash']}" [label="{$nodes['child4']['value']}"]
  "{$nodes['child2']['hash']}" [label="{$nodes['child2']['value']}"]
  "{$nodes['child3']['hash']}" [label="{$nodes['child3']['value']}"]

// The graph edges.
  "{$nodes['root']['hash']}" -> "{$nodes['child1']['hash']}";
  "{$nodes['child1']['hash']}" -> "{$nodes['child4']['hash']}";
  "{$nodes['root']['hash']}" -> "{$nodes['child2']['hash']}";
  "{$nodes['root']['hash']}" -> "{$nodes['child3']['hash']}";
}
EOF;
        $this
            ->export($tree)
            ->shouldReturn($result);

        $this->setDirected(false);

        $result = <<<EOF
graph PHPTreeGraph {
// The graph attributes.
  ratio = fill
  node [style="filled"]

// The graph nodes.
  "{$nodes['root']['hash']}" [label="{$nodes['root']['value']}"]
  "{$nodes['child1']['hash']}" [label="{$nodes['child1']['value']}"]
  "{$nodes['child4']['hash']}" [label="{$nodes['child4']['value']}"]
  "{$nodes['child2']['hash']}" [label="{$nodes['child2']['value']}"]
  "{$nodes['child3']['hash']}" [label="{$nodes['child3']['value']}"]

// The graph edges.
  "{$nodes['root']['hash']}" -- "{$nodes['child1']['hash']}";
  "{$nodes['child1']['hash']}" -- "{$nodes['child4']['hash']}";
  "{$nodes['root']['hash']}" -- "{$nodes['child2']['hash']}";
  "{$nodes['root']['hash']}" -- "{$nodes['child3']['hash']}";
}
EOF;
        $this
            ->export($tree)
            ->shouldReturn($result);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Gv::class);
    }
}
