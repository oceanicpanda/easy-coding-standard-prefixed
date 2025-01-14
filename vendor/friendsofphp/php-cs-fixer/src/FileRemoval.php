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

/**
 * Handles files removal with possibility to remove them on shutdown.
 *
 * @author Adam Klvač <adam@klva.cz>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class FileRemoval
{
    /**
     * List of observed files to be removed.
     *
     * @var array
     */
    private $files = [];
    public function __construct()
    {
        \register_shutdown_function([$this, 'clean']);
    }
    public function __destruct()
    {
        $this->clean();
    }
    /**
     * This class is not intended to be serialized,
     * and cannot be deserialized (see __wakeup method).
     */
    public function __sleep()
    {
        throw new \BadMethodCallException('Cannot serialize ' . __CLASS__);
    }
    /**
     * Disable the deserialization of the class to prevent attacker executing
     * code by leveraging the __destruct method.
     *
     * @see https://owasp.org/www-community/vulnerabilities/PHP_Object_Injection
     */
    public function __wakeup()
    {
        throw new \BadMethodCallException('Cannot unserialize ' . __CLASS__);
    }
    /**
     * Adds a file to be removed.
     *
     * @param string $path
     */
    public function observe($path)
    {
        $this->files[$path] = \true;
    }
    /**
     * Removes a file from shutdown removal.
     *
     * @param string $path
     */
    public function delete($path)
    {
        if (isset($this->files[$path])) {
            unset($this->files[$path]);
        }
        $this->unlink($path);
    }
    /**
     * Removes attached files.
     */
    public function clean()
    {
        foreach ($this->files as $file => $value) {
            $this->unlink($file);
        }
        $this->files = [];
    }
    private function unlink($path)
    {
        @\unlink($path);
    }
}
