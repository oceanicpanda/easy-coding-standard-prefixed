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
namespace PhpCsFixer\RuleSet\Sets;

use PhpCsFixer\RuleSet\AbstractRuleSetDescription;
/**
 * @internal
 */
final class PHP56MigrationSet extends AbstractRuleSetDescription
{
    public function getRules()
    {
        return ['@PHP54Migration' => \true];
    }
    public function getDescription()
    {
        return 'Rules to improve code for PHP 5.6 compatibility.';
    }
}
