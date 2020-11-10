<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer;

use _PhpScoper470d6df94ac0\Symfony\Component\Finder\Finder as BaseFinder;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 */
class Finder extends \_PhpScoper470d6df94ac0\Symfony\Component\Finder\Finder
{
    public function __construct()
    {
        parent::__construct();
        $this->files()->name('*.php')->name('*.phpt')->ignoreDotFiles(\true)->ignoreVCS(\true)->exclude('vendor');
    }
}
