<?php

declare (strict_types=1);
namespace _PhpScoper5928e324b45e\PhpParser\Node\Stmt;

use _PhpScoper5928e324b45e\PhpParser\Node;
class Unset_ extends \_PhpScoper5928e324b45e\PhpParser\Node\Stmt
{
    /** @var Node\Expr[] Variables to unset */
    public $vars;
    /**
     * Constructs an unset node.
     *
     * @param Node\Expr[] $vars       Variables to unset
     * @param array       $attributes Additional attributes
     */
    public function __construct(array $vars, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->vars = $vars;
    }
    public function getSubNodeNames() : array
    {
        return ['vars'];
    }
    public function getType() : string
    {
        return 'Stmt_Unset';
    }
}
