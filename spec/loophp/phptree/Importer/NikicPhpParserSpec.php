<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\phptree\Importer;

use Error;
use loophp\phptree\Importer\NikicPhpParser;
use loophp\phptree\Node\AttributeNodeInterface;
use PhpParser\ParserFactory;
use PhpSpec\ObjectBehavior;

class NikicPhpParserSpec extends ObjectBehavior
{
    public function it_can_import(): void
    {
        $file = __DIR__ . '/../../../../src/Node/Node.php';

        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        try {
            $ast = $parser->parse(file_get_contents($file));
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";

            return;
        }

        $this
            ->import($ast)
            ->shouldImplement(AttributeNodeInterface::class);

        $this
            ->import($ast)
            ->count()
            ->shouldReturn(582);

        $file = __DIR__ . '/../../../../tests/sample.php';

        try {
            $ast = $parser->parse(file_get_contents($file));
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";

            return;
        }

        $this
            ->import($ast)
            ->count()
            ->shouldReturn(109);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(NikicPhpParser::class);
    }
}
