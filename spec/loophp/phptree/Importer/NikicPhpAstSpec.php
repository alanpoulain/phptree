<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\phptree\Importer;

use loophp\phptree\Importer\NikicPhpAst;
use loophp\phptree\Node\AttributeNodeInterface;
use PhpSpec\ObjectBehavior;

class NikicPhpAstSpec extends ObjectBehavior
{
    public function it_can_import(): void
    {
        $file = __DIR__ . '/../../../../src/Node/Node.php';
        $ast = \ast\parse_file($file, 50);

        $this
            ->import($ast)
            ->shouldImplement(AttributeNodeInterface::class);

        $this
            ->import($ast)
            ->count()
            ->shouldReturn(551);

        $file = __DIR__ . '/../../../../tests/sample.php';
        $ast = \ast\parse_file($file, 50);

        $this
            ->import($ast)
            ->count()
            ->shouldReturn(87);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(NikicPhpAst::class);
    }
}
