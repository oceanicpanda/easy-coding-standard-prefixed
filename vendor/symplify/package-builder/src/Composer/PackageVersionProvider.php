<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Composer;

use _PhpScoper78e1a27e740b\Jean85\Exception\ReplacedPackageException;
use _PhpScoper78e1a27e740b\Jean85\PrettyVersions;
use _PhpScoper78e1a27e740b\Jean85\Version;
use OutOfBoundsException;
use _PhpScoper78e1a27e740b\PharIo\Version\InvalidVersionException;
final class PackageVersionProvider
{
    /**
     * Returns current version of package, contains only major and minor.
     */
    public function provide(string $packageName) : string
    {
        try {
            $version = $this->getVersion($packageName, 'symplify/symplify');
            return $version->getPrettyVersion();
        } catch (OutOfBoundsException|InvalidVersionException $exceptoin) {
            return 'Unknown';
        }
    }
    /**
     * Workaround for when the required package is executed in the monorepo or replaced in any other way
     *
     * @see https://github.com/symplify/symplify/pull/2901#issuecomment-771536136
     * @see https://github.com/Jean85/pretty-package-versions/pull/16#issuecomment-620550459
     */
    private function getVersion(string $packageName, string $replacingPackageName) : Version
    {
        try {
            return PrettyVersions::getVersion($packageName);
        } catch (OutOfBoundsException|ReplacedPackageException $exception) {
            return PrettyVersions::getVersion($replacingPackageName);
        }
    }
}
