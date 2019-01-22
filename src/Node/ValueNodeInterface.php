<?php

declare(strict_types = 1);

namespace drupol\phptree\Node;

/**
 * Interface ValueNodeInterface.
 */
interface ValueNodeInterface extends NodeInterface
{
    /**
     * Get the value property.
     *
     * @return null|mixed|string
     *   The value property
     */
    public function getValue();
}
