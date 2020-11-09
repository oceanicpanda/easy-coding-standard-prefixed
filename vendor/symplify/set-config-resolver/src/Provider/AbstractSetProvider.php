<?php

declare (strict_types=1);
namespace Symplify\SetConfigResolver\Provider;

use _PhpScoper0d0ee1ba46d4\Nette\Utils\Strings;
use Symplify\SetConfigResolver\Contract\SetProviderInterface;
use Symplify\SetConfigResolver\Exception\SetNotFoundException;
use Symplify\SetConfigResolver\ValueObject\Set;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
abstract class AbstractSetProvider implements \Symplify\SetConfigResolver\Contract\SetProviderInterface
{
    /**
     * @return string[]
     */
    public function provideSetNames() : array
    {
        $setNames = [];
        $sets = $this->provide();
        foreach ($sets as $set) {
            $setNames[] = $set->getName();
        }
        return $setNames;
    }
    public function provideByName(string $desiredSetName) : ?\Symplify\SetConfigResolver\ValueObject\Set
    {
        // 1. name-based approach
        $sets = $this->provide();
        foreach ($sets as $set) {
            if ($set->getName() !== $desiredSetName) {
                continue;
            }
            return $set;
        }
        // 2. path-based approach
        try {
            $sets = $this->provide();
            foreach ($sets as $set) {
                // possible bug for PHAR files, see https://bugs.php.net/bug.php?id=52769
                // this is very tricky to handle, see https://stackoverflow.com/questions/27838025/how-to-get-a-phar-file-real-directory-within-the-phar-file-code
                $setUniqueId = $this->resolveSetUniquePathId($set->getSetFileInfo()->getPathname());
                $desiredSetUniqueId = $this->resolveSetUniquePathId($desiredSetName);
                if ($setUniqueId !== $desiredSetUniqueId) {
                    continue;
                }
                return $set;
            }
        } catch (\Symplify\SymplifyKernel\Exception\ShouldNotHappenException $shouldNotHappenException) {
        }
        $message = \sprintf('Set "%s" was not found', $desiredSetName);
        throw new \Symplify\SetConfigResolver\Exception\SetNotFoundException($message, $desiredSetName, $this->provideSetNames());
    }
    private function resolveSetUniquePathId(string $setPath) : string
    {
        $setPath = \_PhpScoper0d0ee1ba46d4\Nette\Utils\Strings::after($setPath, \DIRECTORY_SEPARATOR, -2);
        if ($setPath === null) {
            throw new \Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $setPath;
    }
}