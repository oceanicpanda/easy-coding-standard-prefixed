<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeVisitor;

use _PhpScoperd74b3ed28382\Nette\Utils\Strings;
use _PhpScoperd74b3ed28382\PhpParser\Node;
use _PhpScoperd74b3ed28382\PhpParser\Node\Name;
use _PhpScoperd74b3ed28382\PhpParser\Node\Name\FullyQualified;
use _PhpScoperd74b3ed28382\PhpParser\NodeVisitorAbstract;
use Symplify\PhpConfigPrinter\Naming\ClassNaming;
final class ImportFullyQualifiedNamesNodeVisitor extends \_PhpScoperd74b3ed28382\PhpParser\NodeVisitorAbstract
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var string[]
     */
    private $nameImports = [];
    public function __construct(\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->nameImports = [];
        return null;
    }
    public function enterNode(\_PhpScoperd74b3ed28382\PhpParser\Node $node) : ?\_PhpScoperd74b3ed28382\PhpParser\Node
    {
        if (!$node instanceof \_PhpScoperd74b3ed28382\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $fullyQualifiedName = $node->toString();
        // namespace-less class name
        if (\_PhpScoperd74b3ed28382\Nette\Utils\Strings::startsWith($fullyQualifiedName, '\\')) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (!\_PhpScoperd74b3ed28382\Nette\Utils\Strings::contains($fullyQualifiedName, '\\')) {
            return new \_PhpScoperd74b3ed28382\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        $this->nameImports[] = $fullyQualifiedName;
        return new \_PhpScoperd74b3ed28382\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return string[]
     */
    public function getNameImports() : array
    {
        return $this->nameImports;
    }
}
