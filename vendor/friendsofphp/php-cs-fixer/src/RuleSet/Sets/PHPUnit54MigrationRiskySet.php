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
final class PHPUnit54MigrationRiskySet extends AbstractRuleSetDescription
{
    public function getRules()
    {
        return ['@PHPUnit52Migration:risky' => \true, 'php_unit_mock' => ['target' => '5.4']];
    }
    public function getDescription()
    {
        return 'Rules to improve tests code for PHPUnit 5.4 compatibility.';
    }
}
