<?php

declare (strict_types=1);
namespace _PhpScoper81b3ff5ab9fe\PhpParser\Node\Stmt;

use _PhpScoper81b3ff5ab9fe\PhpParser\Node;
class Namespace_ extends \_PhpScoper81b3ff5ab9fe\PhpParser\Node\Stmt
{
    /* For use in the "kind" attribute */
    const KIND_SEMICOLON = 1;
    const KIND_BRACED = 2;
    /** @var null|Node\Name Name */
    public $name;
    /** @var Node\Stmt[] Statements */
    public $stmts;
    /**
     * Constructs a namespace node.
     *
     * @param null|Node\Name   $name       Name
     * @param null|Node\Stmt[] $stmts      Statements
     * @param array            $attributes Additional attributes
     */
    public function __construct(\_PhpScoper81b3ff5ab9fe\PhpParser\Node\Name $name = null, $stmts = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = $name;
        $this->stmts = $stmts;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'stmts'];
    }
    public function getType() : string
    {
        return 'Stmt_Namespace';
    }
}
