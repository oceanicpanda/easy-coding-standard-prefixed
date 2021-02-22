<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperfcee700af3df\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoperfcee700af3df\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoperfcee700af3df\Nette\HtmlStringable::class, \_PhpScoperfcee700af3df\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoperfcee700af3df\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoperfcee700af3df\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoperfcee700af3df\Nette\Localization\Translator::class, \_PhpScoperfcee700af3df\Nette\Localization\ITranslator::class);
}
