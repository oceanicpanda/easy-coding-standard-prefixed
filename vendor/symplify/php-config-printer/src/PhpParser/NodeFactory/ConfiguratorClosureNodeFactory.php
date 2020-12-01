<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\PhpParser\NodeFactory;

use _PhpScoperd74b3ed28382\PhpParser\Node;
use _PhpScoperd74b3ed28382\PhpParser\Node\Expr\Closure;
use _PhpScoperd74b3ed28382\PhpParser\Node\Expr\Variable;
use _PhpScoperd74b3ed28382\PhpParser\Node\Identifier;
use _PhpScoperd74b3ed28382\PhpParser\Node\Name\FullyQualified;
use _PhpScoperd74b3ed28382\PhpParser\Node\Param;
use _PhpScoperd74b3ed28382\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperd74b3ed28382\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ConfiguratorClosureNodeFactory
{
    /**
     * @param Node[] $stmts
     */
    public function createContainerClosureFromStmts(array $stmts) : \_PhpScoperd74b3ed28382\PhpParser\Node\Expr\Closure
    {
        $param = $this->createContainerConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    /**
     * @param Node[] $stmts
     */
    public function createRoutingClosureFromStmts(array $stmts) : \_PhpScoperd74b3ed28382\PhpParser\Node\Expr\Closure
    {
        $param = $this->createRoutingConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    private function createContainerConfiguratorParam() : \_PhpScoperd74b3ed28382\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \_PhpScoperd74b3ed28382\PhpParser\Node\Expr\Variable(\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        return new \_PhpScoperd74b3ed28382\PhpParser\Node\Param($containerConfiguratorVariable, null, new \_PhpScoperd74b3ed28382\PhpParser\Node\Name\FullyQualified(\_PhpScoperd74b3ed28382\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class));
    }
    private function createRoutingConfiguratorParam() : \_PhpScoperd74b3ed28382\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \_PhpScoperd74b3ed28382\PhpParser\Node\Expr\Variable(\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        return new \_PhpScoperd74b3ed28382\PhpParser\Node\Param($containerConfiguratorVariable, null, new \_PhpScoperd74b3ed28382\PhpParser\Node\Name\FullyQualified(\_PhpScoperd74b3ed28382\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator::class));
    }
    private function createClosureFromParamAndStmts(\_PhpScoperd74b3ed28382\PhpParser\Node\Param $param, array $stmts) : \_PhpScoperd74b3ed28382\PhpParser\Node\Expr\Closure
    {
        $closure = new \_PhpScoperd74b3ed28382\PhpParser\Node\Expr\Closure(['params' => [$param], 'stmts' => $stmts, 'static' => \true]);
        // is PHP 7.1? → add "void" return type
        if (\version_compare(\PHP_VERSION, '7.1.0') >= 0) {
            $closure->returnType = new \_PhpScoperd74b3ed28382\PhpParser\Node\Identifier('void');
        }
        return $closure;
    }
}
