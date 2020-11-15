<?php

declare (strict_types=1);
namespace _PhpScoper70072c07b02b\PhpParser\NodeVisitor;

use _PhpScoper70072c07b02b\PhpParser\Node;
use _PhpScoper70072c07b02b\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends \_PhpScoper70072c07b02b\PhpParser\NodeVisitorAbstract
{
    public function enterNode(\_PhpScoper70072c07b02b\PhpParser\Node $origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}
