<?php

declare (strict_types=1);
namespace Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass;

use _PhpScoperf3dc21757def\Nette\Utils\Strings;
use ReflectionClass;
use ReflectionMethod;
use _PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\Definition;
use _PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\Reference;
use Symplify\AutowireArrayParameter\DocBlock\ParamTypeDocBlockResolver;
use Symplify\AutowireArrayParameter\Skipper\ParameterSkipper;
use Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver;
use Symplify\PackageBuilder\DependencyInjection\DefinitionFinder;
/**
 * @inspiration https://github.com/nette/di/pull/178
 * @see \Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPassTest
 */
final class AutowireArrayParameterCompilerPass implements \_PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * These namespaces are already configured by their bundles/extensions.
     * @var string[]
     */
    private const EXCLUDED_NAMESPACES = ['Doctrine', 'JMS', 'Symfony', 'Sensio', 'Knp', 'EasyCorp', 'Sonata', 'Twig'];
    /**
     * Classes that create circular dependencies
     * @var string[]
     * @noRector
     */
    private $excludedFatalClasses = ['_PhpScoperf3dc21757def\\Symfony\\Component\\Form\\FormExtensionInterface', '_PhpScoperf3dc21757def\\Symfony\\Component\\Asset\\PackageInterface', '_PhpScoperf3dc21757def\\Symfony\\Component\\Config\\Loader\\LoaderInterface', '_PhpScoperf3dc21757def\\Symfony\\Component\\VarDumper\\Dumper\\ContextProvider\\ContextProviderInterface', '_PhpScoperf3dc21757def\\EasyCorp\\Bundle\\EasyAdminBundle\\Form\\Type\\Configurator\\TypeConfiguratorInterface', '_PhpScoperf3dc21757def\\Sonata\\CoreBundle\\Model\\Adapter\\AdapterInterface', '_PhpScoperf3dc21757def\\Sonata\\Doctrine\\Adapter\\AdapterChain', '_PhpScoperf3dc21757def\\Sonata\\Twig\\Extension\\TemplateExtension'];
    /**
     * @var DefinitionFinder
     */
    private $definitionFinder;
    /**
     * @var ParameterTypeResolver
     */
    private $parameterTypeResolver;
    /**
     * @var ParameterSkipper
     */
    private $parameterSkipper;
    /**
     * @param string[] $excludedFatalClasses
     */
    public function __construct(array $excludedFatalClasses = [])
    {
        $this->definitionFinder = new \Symplify\PackageBuilder\DependencyInjection\DefinitionFinder();
        $paramTypeDocBlockResolver = new \Symplify\AutowireArrayParameter\DocBlock\ParamTypeDocBlockResolver();
        $this->parameterTypeResolver = new \Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver($paramTypeDocBlockResolver);
        $this->parameterSkipper = new \Symplify\AutowireArrayParameter\Skipper\ParameterSkipper($this->parameterTypeResolver, $excludedFatalClasses);
    }
    public function process(\_PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $definitions = $containerBuilder->getDefinitions();
        foreach ($definitions as $definition) {
            if ($this->shouldSkipDefinition($containerBuilder, $definition)) {
                continue;
            }
            /** @var ReflectionClass $reflectionClass */
            $reflectionClass = $containerBuilder->getReflectionClass($definition->getClass());
            /** @var ReflectionMethod $constructorMethodReflection */
            $constructorMethodReflection = $reflectionClass->getConstructor();
            $this->processParameters($containerBuilder, $constructorMethodReflection, $definition);
        }
    }
    private function shouldSkipDefinition(\_PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\Definition $definition) : bool
    {
        if ($definition->isAbstract()) {
            return \true;
        }
        if ($definition->getClass() === null) {
            return \true;
        }
        // here class name can be "%parameter.class%"
        $parameterBag = $containerBuilder->getParameterBag();
        $resolvedClassName = $parameterBag->resolveValue($definition->getClass());
        // skip 3rd party classes, they're autowired by own config
        $excludedNamespacePattern = '#^(' . \implode('|', self::EXCLUDED_NAMESPACES) . ')\\\\#';
        if ((bool) \_PhpScoperf3dc21757def\Nette\Utils\Strings::match($resolvedClassName, $excludedNamespacePattern)) {
            return \true;
        }
        if (\in_array($resolvedClassName, $this->excludedFatalClasses, \true)) {
            return \true;
        }
        if ($definition->getFactory()) {
            return \true;
        }
        $reflectionClass = $containerBuilder->getReflectionClass($definition->getClass());
        if (!$reflectionClass instanceof \ReflectionClass) {
            return \true;
        }
        if (!$reflectionClass->hasMethod('__construct')) {
            return \true;
        }
        /** @var ReflectionMethod $constructorMethodReflection */
        $constructorMethodReflection = $reflectionClass->getConstructor();
        return !$constructorMethodReflection->getParameters();
    }
    private function processParameters(\_PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \ReflectionMethod $reflectionMethod, \_PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\Definition $definition) : void
    {
        $reflectionParameters = $reflectionMethod->getParameters();
        foreach ($reflectionParameters as $reflectionParameter) {
            if ($this->parameterSkipper->shouldSkipParameter($reflectionMethod, $definition, $reflectionParameter)) {
                continue;
            }
            $parameterType = $this->parameterTypeResolver->resolveParameterType($reflectionParameter->getName(), $reflectionMethod);
            if ($parameterType === null) {
                continue;
            }
            $definitionsOfType = $this->definitionFinder->findAllByType($containerBuilder, $parameterType);
            $definitionsOfType = $this->filterOutAbstractDefinitions($definitionsOfType);
            $argumentName = '$' . $reflectionParameter->getName();
            $definition->setArgument($argumentName, $this->createReferencesFromDefinitions($definitionsOfType));
        }
    }
    /**
     * Abstract definitions cannot be the target of references
     *
     * @param Definition[] $definitions
     * @return Definition[]
     */
    private function filterOutAbstractDefinitions(array $definitions) : array
    {
        foreach ($definitions as $key => $definition) {
            if ($definition->isAbstract()) {
                unset($definitions[$key]);
            }
        }
        return $definitions;
    }
    /**
     * @param Definition[] $definitions
     * @return Reference[]
     */
    private function createReferencesFromDefinitions(array $definitions) : array
    {
        $references = [];
        $definitionOfTypeNames = \array_keys($definitions);
        foreach ($definitionOfTypeNames as $definitionOfTypeName) {
            $references[] = new \_PhpScoperf3dc21757def\Symfony\Component\DependencyInjection\Reference($definitionOfTypeName);
        }
        return $references;
    }
}
