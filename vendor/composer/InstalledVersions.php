<?php

namespace _PhpScoperd675aaf00c76\Composer;

use _PhpScoperd675aaf00c76\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '0809938c95e13558e3c2a141fa9653e1be5e0ca0', 'name' => 'symplify/easy-coding-standard'), 'versions' => array('composer/package-versions-deprecated' => array('pretty_version' => '1.8.0', 'version' => '1.8.0.0', 'aliases' => array(), 'reference' => '98df7f1b293c0550bd5b1ce6b60b59bdda23aa47'), 'composer/semver' => array('pretty_version' => '1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => '84c47f3d8901440403217afc120683c7385aecb8'), 'composer/xdebug-handler' => array('pretty_version' => '1.4.0', 'version' => '1.4.0.0', 'aliases' => array(), 'reference' => 'cbe23383749496fe0f373345208b79568e4bc248'), 'dealerdirect/phpcodesniffer-composer-installer' => array('pretty_version' => 'v0.7.0', 'version' => '0.7.0.0', 'aliases' => array(), 'reference' => 'e8d808670b8f882188368faaf1144448c169c0b7'), 'doctrine/annotations' => array('pretty_version' => 'v1.2.0', 'version' => '1.2.0.0', 'aliases' => array(), 'reference' => 'd9b1a37e9351ddde1f19f09a02e3d6ee92e82efd'), 'doctrine/lexer' => array('pretty_version' => 'v1.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => '2f708a85bb3aab5d99dab8be435abd73e0b18acb'), 'friendsofphp/php-cs-fixer' => array('pretty_version' => 'v2.16.0', 'version' => '2.16.0.0', 'aliases' => array(), 'reference' => 'ceaff36bee1ed3f1bbbedca36d2528c0826c336d'), 'jean85/pretty-package-versions' => array('pretty_version' => '1.5.0', 'version' => '1.5.0.0', 'aliases' => array(), 'reference' => 'e9f4324e88b8664be386d90cf60fbc202e1f7fc9'), 'nette/finder' => array('pretty_version' => 'v2.5.0', 'version' => '2.5.0.0', 'aliases' => array(), 'reference' => '6be1b83ea68ac558aff189d640abe242e0306fe2'), 'nette/neon' => array('pretty_version' => 'v3.2.0', 'version' => '3.2.0.0', 'aliases' => array(), 'reference' => '72dd80316595d4b5c5312ea4e9beb53f3ba823d7'), 'nette/robot-loader' => array('pretty_version' => 'v3.2.0', 'version' => '3.2.0.0', 'aliases' => array(), 'reference' => '0712a0e39ae7956d6a94c0ab6ad41aa842544b5c'), 'nette/utils' => array('pretty_version' => 'v3.0.0', 'version' => '3.0.0.0', 'aliases' => array(), 'reference' => 'ec1e4055c295d73bb9e8ce27be859f434a6f6806'), 'nikic/php-parser' => array('pretty_version' => 'v4.10.2', 'version' => '4.10.2.0', 'aliases' => array(), 'reference' => '658f1be311a230e0907f5dfe0213742aff0596de'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.2 - 1.8.99')), 'paragonie/random_compat' => array('pretty_version' => 'v1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'a1d9f267eb8b8ad560e54e397a5ed1e3b78097d1'), 'php-cs-fixer/diff' => array('pretty_version' => 'v1.3.0', 'version' => '1.3.0.0', 'aliases' => array(), 'reference' => '78bb099e9c16361126c86ce82ec4405ebab8e756'), 'phpstan/phpdoc-parser' => array('pretty_version' => '0.4.5', 'version' => '0.4.5.0', 'aliases' => array(), 'reference' => '956e7215c7c740d1226e7c03677140063918ec7d'), 'psr/cache' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => '9e66031f41fbbdda45ee11e93c45d480ccba3eb3'), 'psr/cache-implementation' => array('provided' => array(0 => '1.0')), 'psr/container' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f'), 'psr/container-implementation' => array('provided' => array(0 => '1.0')), 'psr/event-dispatcher-implementation' => array('provided' => array(0 => '1.0')), 'psr/log' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => 'fe0936ee26643249e916849d48e3a51d5f5e278b'), 'psr/log-implementation' => array('provided' => array(0 => '1.0')), 'psr/simple-cache' => array('pretty_version' => '1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => '753fa598e8f3b9966c886fe13f370baa45ef0e24'), 'psr/simple-cache-implementation' => array('provided' => array(0 => '1.0')), 'sebastian/diff' => array('pretty_version' => '3.0.2', 'version' => '3.0.2.0', 'aliases' => array(), 'reference' => '720fcc7e9b5cf384ea68d9d930d480907a0c1a29'), 'slevomat/coding-standard' => array('pretty_version' => '6.4.0', 'version' => '6.4.0.0', 'aliases' => array(), 'reference' => 'bf3a16a630d8245c350b459832a71afa55c02fd3'), 'squizlabs/php_codesniffer' => array('pretty_version' => '3.5.6', 'version' => '3.5.6.0', 'aliases' => array(), 'reference' => 'e97627871a7eab2f70e59166072a6b767d5834e0'), 'symfony/cache' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => '72d5cdc6920f889290beb65fa96b5e9d4515e382'), 'symfony/cache-contracts' => array('pretty_version' => 'v1.1.7', 'version' => '1.1.7.0', 'aliases' => array(), 'reference' => 'af50d14ada9e4e82cfabfabdc502d144f89be0a1'), 'symfony/cache-implementation' => array('provided' => array(0 => '1.0')), 'symfony/config' => array('pretty_version' => 'v5.1.0', 'version' => '5.1.0.0', 'aliases' => array(), 'reference' => 'b8623ef3d99fe62a34baf7a111b576216965f880'), 'symfony/console' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => '35d9077f495c6d184d9930f7a7ecbd1ad13c7ab8'), 'symfony/debug' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => 'b24b791f817116b29e52a63e8544884cf9a40757'), 'symfony/dependency-injection' => array('pretty_version' => 'v5.1.0', 'version' => '5.1.0.0', 'aliases' => array(), 'reference' => '6a6791e9584273b32eeb01790da4c7446d87a621'), 'symfony/deprecation-contracts' => array('pretty_version' => 'v2.1.0', 'version' => '2.1.0.0', 'aliases' => array(), 'reference' => 'ede224dcbc36138943a296107db2b8b2a690ac1c'), 'symfony/error-handler' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => 'e1acb58dc6a8722617fe56565f742bcf7e8744bf'), 'symfony/event-dispatcher' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => 'ab1c43e17fff802bef0a898f3bc088ac33b8e0e1'), 'symfony/event-dispatcher-contracts' => array('pretty_version' => 'v1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '8fa2cf2177083dd59cf8e44ea4b6541764fbda69'), 'symfony/event-dispatcher-implementation' => array('provided' => array(0 => '1.1')), 'symfony/filesystem' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => 'd12b01cba60be77b583c9af660007211e3909854'), 'symfony/finder' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => 'ce8743441da64c41e2a667b8eb66070444ed911e'), 'symfony/http-foundation' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => '502040dd2b0cf0a292defeb6145f4d7a4753c99c'), 'symfony/http-kernel' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => '5a5e7237d928aa98ff8952050cbbf0135899b6b0'), 'symfony/mime' => array('pretty_version' => 'v4.3.0', 'version' => '4.3.0.0', 'aliases' => array(), 'reference' => '0b166aee243364cd9de05755d2e9651876090abb'), 'symfony/options-resolver' => array('pretty_version' => 'v3.0.0', 'version' => '3.0.0.0', 'aliases' => array(), 'reference' => '8e68c053a39e26559357cc742f01a7182ce40785'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.8.0', 'version' => '1.8.0.0', 'aliases' => array(), 'reference' => '7cc359f1b7b80fc25ed7796be7d96adc9b354bae'), 'symfony/polyfill-intl-idn' => array('pretty_version' => 'v1.20.0', 'version' => '1.20.0.0', 'aliases' => array(), 'reference' => '3b75acd829741c768bc8b1f84eb33265e7cc5117'), 'symfony/polyfill-intl-normalizer' => array('pretty_version' => 'v1.10.0', 'version' => '1.10.0.0', 'aliases' => array(), 'reference' => 'f8ed52909fc049b42a772c64ec1e6b31792abad6'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.1.0', 'version' => '1.1.0.0', 'aliases' => array(), 'reference' => '1289d16209491b584839022f29257ad859b8532d'), 'symfony/polyfill-php70' => array('pretty_version' => 'v1.0.0', 'version' => '1.0.0.0', 'aliases' => array(), 'reference' => '7f7f3c9c2b9f17722e0cd64fdb4f957330c53146'), 'symfony/polyfill-php72' => array('pretty_version' => 'v1.10.0', 'version' => '1.10.0.0', 'aliases' => array(), 'reference' => '9050816e2ca34a8e916c3a0ae8b9c2fccf68b631'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.9.0', 'version' => '1.9.0.0', 'aliases' => array(), 'reference' => '990ca8fa94736211d2b305178c3fb2527e1fbce1'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.15.0', 'version' => '1.15.0.0', 'aliases' => array(), 'reference' => '8854dc880784d2ae32908b75824754339b5c0555'), 'symfony/process' => array('pretty_version' => 'v3.3.0', 'version' => '3.3.0.0', 'aliases' => array(), 'reference' => '8e30690c67aafb6c7992d6d8eb0d707807dd3eaf'), 'symfony/service-contracts' => array('pretty_version' => 'v1.1.6', 'version' => '1.1.6.0', 'aliases' => array(), 'reference' => 'ea7263d6b6d5f798b56a45a5b8d686725f2719a3'), 'symfony/service-implementation' => array('provided' => array(0 => '1.0')), 'symfony/stopwatch' => array('pretty_version' => 'v3.0.0', 'version' => '3.0.0.0', 'aliases' => array(), 'reference' => '6aeac8907e3e1340a0033b0a9ec075f8e6524800'), 'symfony/var-dumper' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => 'eade2890f8b0eeb279b6cf41b50a10007294490f'), 'symfony/var-exporter' => array('pretty_version' => 'v4.2.0', 'version' => '4.2.0.0', 'aliases' => array(), 'reference' => '08250457428e06289d21ed52397b0ae336abf54b'), 'symfony/yaml' => array('pretty_version' => 'v4.4.0', 'version' => '4.4.0.0', 'aliases' => array(), 'reference' => '76de473358fe802578a415d5bb43c296cf09d211'), 'symplify/autowire-array-parameter' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'f23d16261bf25200742f0ec50123719ecc4ea917'), 'symplify/coding-standard' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '2547074b667748b9462e217f71780a98e40b7b7e'), 'symplify/composer-json-manipulator' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '9920d1017e64f9deac0c9b5c7ae4bedb1968e651'), 'symplify/console-color-diff' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'f7e3b2e202de08deaac7aad45947cfef0f873449'), 'symplify/easy-coding-standard' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '0809938c95e13558e3c2a141fa9653e1be5e0ca0'), 'symplify/easy-testing' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '170ee891547dde4d63bc29b00afa22884c6df25c'), 'symplify/markdown-diff' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '92d484c06a76031d7dc0e9e3998bdeecddda21a4'), 'symplify/package-builder' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'e4094c248504b34b0cfc624e320c3acfc0ceafbb'), 'symplify/php-config-printer' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '79d557daabb9876358d08f4df306a621f6a0322b'), 'symplify/rule-doc-generator' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '9725bef13482a0349ca292a807ce4add3e6b479b'), 'symplify/set-config-resolver' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '57b22ea7ed019d5f682d44a23cf401ed9ed04f7f'), 'symplify/skipper' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '9f3f0aefb1f69d3301a18b5ae5c1cf4e4378e66c'), 'symplify/smart-file-system' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => 'abc529006989de756721cb1ec21a3791b7f1bd68'), 'symplify/symplify-kernel' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(0 => '9.0.x-dev'), 'reference' => '1bc647c23f9f6f702ae3c9eedb90bf2a4c930a6e')));
    public static function getInstalledPackages()
    {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName)
    {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(\_PhpScoperd675aaf00c76\Composer\Semver\VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        $ranges = array();
        if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            $ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
        }
        if (\array_key_exists('aliases', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
        }
        if (\array_key_exists('replaced', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
        }
        if (\array_key_exists('provided', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
        }
        return \implode(' || ', $ranges);
    }
    public static function getVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['version'];
    }
    public static function getPrettyVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['pretty_version'];
    }
    public static function getReference($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['reference'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['reference'];
    }
    public static function getRootPackage()
    {
        return self::$installed['root'];
    }
    public static function getRawData()
    {
        return self::$installed;
    }
    public static function reload($data)
    {
        self::$installed = $data;
    }
}
