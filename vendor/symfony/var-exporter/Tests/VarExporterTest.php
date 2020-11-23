<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests;

use _PhpScopere341acab57d4\PHPUnit\Framework\TestCase;
use _PhpScopere341acab57d4\Symfony\Component\VarDumper\Test\VarDumperTestTrait;
use _PhpScopere341acab57d4\Symfony\Component\VarExporter\Internal\Registry;
use _PhpScopere341acab57d4\Symfony\Component\VarExporter\VarExporter;
class VarExporterTest extends \_PhpScopere341acab57d4\PHPUnit\Framework\TestCase
{
    use VarDumperTestTrait;
    /**
     * @expectedException \Symfony\Component\VarExporter\Exception\ClassNotFoundException
     * @expectedExceptionMessage Class "SomeNotExistingClass" not found.
     */
    public function testPhpIncompleteClassesAreForbidden()
    {
        $unserializeCallback = \ini_set('unserialize_callback_func', 'var_dump');
        try {
            \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Internal\Registry::unserialize(array(), array('O:20:"SomeNotExistingClass":0:{}'));
        } finally {
            $this->assertSame('var_dump', \ini_set('unserialize_callback_func', $unserializeCallback));
        }
    }
    /**
     * @dataProvider provideFailingSerialization
     * @expectedException \Symfony\Component\VarExporter\Exception\NotInstantiableTypeException
     * @expectedExceptionMessageRegexp Type ".*" is not instantiable.
     */
    public function testFailingSerialization($value)
    {
        $expectedDump = $this->getDump($value);
        try {
            \_PhpScopere341acab57d4\Symfony\Component\VarExporter\VarExporter::export($value);
        } finally {
            $this->assertDumpEquals(\rtrim($expectedDump), $value);
        }
    }
    public function provideFailingSerialization()
    {
        (yield array(\hash_init('md5')));
        (yield array(new \ReflectionClass('stdClass')));
        (yield array((new \ReflectionFunction(function () : int {
        }))->getReturnType()));
        (yield array(new \ReflectionGenerator((function () {
            (yield 123);
        })())));
        (yield array(function () {
        }));
        (yield array(function () {
            (yield 123);
        }));
        (yield array(new \SplFileInfo(__FILE__)));
        (yield array($h = \fopen(__FILE__, 'r')));
        (yield array(array($h)));
        $a = new class
        {
        };
        (yield array($a));
        $a = array(null, $h);
        $a[0] =& $a;
        (yield array($a));
    }
    /**
     * @dataProvider provideExport
     */
    public function testExport(string $testName, $value, bool $staticValueExpected = \false)
    {
        $dumpedValue = $this->getDump($value);
        $isStaticValue = \true;
        $marshalledValue = \_PhpScopere341acab57d4\Symfony\Component\VarExporter\VarExporter::export($value, $isStaticValue);
        $this->assertSame($staticValueExpected, $isStaticValue);
        if ('var-on-sleep' !== $testName) {
            $this->assertDumpEquals($dumpedValue, $value);
        }
        $dump = "<?php\n\nreturn " . $marshalledValue . ";\n";
        $dump = \str_replace(\var_export(__FILE__, \true), "\\dirname(__DIR__).\\DIRECTORY_SEPARATOR.'VarExporterTest.php'", $dump);
        $fixtureFile = __DIR__ . '/Fixtures/' . $testName . '.php';
        $this->assertStringEqualsFile($fixtureFile, $dump);
        if ('incomplete-class' === $testName || 'external-references' === $testName) {
            return;
        }
        $marshalledValue = (include $fixtureFile);
        if (!$isStaticValue) {
            if ($value instanceof \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyWakeup) {
                $value->bis = null;
            }
            $this->assertDumpEquals($value, $marshalledValue);
        } else {
            $this->assertSame($value, $marshalledValue);
        }
    }
    public function provideExport()
    {
        (yield array('multiline-string', array("\0\0\r\nA" => "B\rC\n\n"), \true));
        (yield array('bool', \true, \true));
        (yield array('simple-array', array(123, array('abc')), \true));
        (yield array('datetime', \DateTime::createFromFormat('U', 0)));
        $value = new \ArrayObject();
        $value[0] = 1;
        $value->foo = new \ArrayObject();
        $value[1] = $value;
        (yield array('array-object', $value));
        (yield array('array-iterator', new \ArrayIterator(array(123), 1)));
        (yield array('array-object-custom', new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyArrayObject(array(234))));
        $value = new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MySerializable();
        (yield array('serializable', array($value, $value)));
        $value = new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyWakeup();
        $value->sub = new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyWakeup();
        $value->sub->sub = 123;
        $value->sub->bis = 123;
        $value->sub->baz = 123;
        (yield array('wakeup', $value));
        (yield array('clone', array(new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyCloneable(), new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyNotCloneable())));
        (yield array('private', array(new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyPrivateValue(123, 234), new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyPrivateChildValue(123, 234))));
        $value = new \SplObjectStorage();
        $value[new \stdClass()] = 345;
        (yield array('spl-object-storage', $value));
        (yield array('incomplete-class', \unserialize('O:20:"SomeNotExistingClass":0:{}')));
        $value = array((object) array());
        $value[1] =& $value[0];
        $value[2] = $value[0];
        (yield array('hard-references', $value));
        $value = array();
        $value[0] =& $value;
        (yield array('hard-references-recursive', $value));
        static $value = array(123);
        (yield array('external-references', array(&$value), \true));
        unset($value);
        $value = new \Error();
        $rt = new \ReflectionProperty('Error', 'trace');
        $rt->setAccessible(\true);
        $rt->setValue($value, array('file' => __FILE__, 'line' => 123));
        $rl = new \ReflectionProperty('Error', 'line');
        $rl->setAccessible(\true);
        $rl->setValue($value, 234);
        (yield array('error', $value));
        (yield array('var-on-sleep', new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\GoodNight()));
        $value = new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\FinalError(\false);
        $rt->setValue($value, array());
        $rl->setValue($value, 123);
        (yield array('final-error', $value));
        (yield array('final-array-iterator', new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\FinalArrayIterator()));
        (yield array('final-stdclass', new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\FinalStdClass()));
        $value = new \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyWakeup();
        $value->bis = new \ReflectionClass($value);
        (yield array('wakeup-refl', $value));
    }
}
class MySerializable implements \Serializable
{
    public function serialize()
    {
        return '123';
    }
    public function unserialize($data)
    {
        // no-op
    }
}
class MyWakeup
{
    public $sub;
    public $bis;
    public $baz;
    public $def = 234;
    public function __sleep()
    {
        return array('sub', 'baz');
    }
    public function __wakeup()
    {
        if (123 === $this->sub) {
            $this->bis = 123;
            $this->baz = 123;
        }
    }
}
class MyCloneable
{
    public function __clone()
    {
        throw new \Exception('__clone should never be called');
    }
}
class MyNotCloneable
{
    private function __clone()
    {
        throw new \Exception('__clone should never be called');
    }
}
class MyPrivateValue
{
    protected $prot;
    private $priv;
    public function __construct($prot, $priv)
    {
        $this->prot = $prot;
        $this->priv = $priv;
    }
}
class MyPrivateChildValue extends \_PhpScopere341acab57d4\Symfony\Component\VarExporter\Tests\MyPrivateValue
{
}
class MyArrayObject extends \ArrayObject
{
    private $unused = 123;
    public function __construct(array $array)
    {
        parent::__construct($array, 1);
    }
    public function setFlags($flags)
    {
        throw new \BadMethodCallException('Calling MyArrayObject::setFlags() is forbidden');
    }
}
class GoodNight
{
    public function __sleep()
    {
        $this->good = 'night';
        return array('good');
    }
}
final class FinalError extends \Error
{
    public function __construct(bool $throw = \true)
    {
        if ($throw) {
            throw new \BadMethodCallException('Should not be called.');
        }
    }
}
final class FinalArrayIterator extends \ArrayIterator
{
    public function serialize()
    {
        return \serialize(array(123, parent::serialize()));
    }
    public function unserialize($data)
    {
        if ('' === $data) {
            throw new \InvalidArgumentException('Serialized data is empty.');
        }
        list(, $data) = \unserialize($data);
        parent::unserialize($data);
    }
}
final class FinalStdClass extends \stdClass
{
    public function __clone()
    {
        throw new \BadMethodCallException('Should not be called.');
    }
}
