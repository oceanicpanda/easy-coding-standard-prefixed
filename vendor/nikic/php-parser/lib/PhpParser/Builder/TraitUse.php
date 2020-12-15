<?php

declare (strict_types=1);
namespace _PhpScoper80dbed43490f\PhpParser\Builder;

use _PhpScoper80dbed43490f\PhpParser\Builder;
use _PhpScoper80dbed43490f\PhpParser\BuilderHelpers;
use _PhpScoper80dbed43490f\PhpParser\Node;
use _PhpScoper80dbed43490f\PhpParser\Node\Stmt;
class TraitUse implements \_PhpScoper80dbed43490f\PhpParser\Builder
{
    protected $traits = [];
    protected $adaptations = [];
    /**
     * Creates a trait use builder.
     *
     * @param Node\Name|string ...$traits Names of used traits
     */
    public function __construct(...$traits)
    {
        foreach ($traits as $trait) {
            $this->and($trait);
        }
    }
    /**
     * Adds used trait.
     *
     * @param Node\Name|string $trait Trait name
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function and($trait)
    {
        $this->traits[] = \_PhpScoper80dbed43490f\PhpParser\BuilderHelpers::normalizeName($trait);
        return $this;
    }
    /**
     * Adds trait adaptation.
     *
     * @param Stmt\TraitUseAdaptation|Builder\TraitUseAdaptation $adaptation Trait adaptation
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function with($adaptation)
    {
        $adaptation = \_PhpScoper80dbed43490f\PhpParser\BuilderHelpers::normalizeNode($adaptation);
        if (!$adaptation instanceof \_PhpScoper80dbed43490f\PhpParser\Node\Stmt\TraitUseAdaptation) {
            throw new \LogicException('Adaptation must have type TraitUseAdaptation');
        }
        $this->adaptations[] = $adaptation;
        return $this;
    }
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \_PhpScoper80dbed43490f\PhpParser\Node
    {
        return new \_PhpScoper80dbed43490f\PhpParser\Node\Stmt\TraitUse($this->traits, $this->adaptations);
    }
}
