<?php

declare (strict_types=1);
namespace _PhpScoper470d6df94ac0\Migrify\PhpConfigPrinter\Contract;

interface YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void;
    public function getYamlContent() : string;
}
