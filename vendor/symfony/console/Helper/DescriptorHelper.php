<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperef870243cfdb\Symfony\Component\Console\Helper;

use _PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\DescriptorInterface;
use _PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\JsonDescriptor;
use _PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\MarkdownDescriptor;
use _PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\TextDescriptor;
use _PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\XmlDescriptor;
use _PhpScoperef870243cfdb\Symfony\Component\Console\Exception\InvalidArgumentException;
use _PhpScoperef870243cfdb\Symfony\Component\Console\Output\OutputInterface;
/**
 * This class adds helper method to describe objects in various formats.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DescriptorHelper extends \_PhpScoperef870243cfdb\Symfony\Component\Console\Helper\Helper
{
    /**
     * @var DescriptorInterface[]
     */
    private $descriptors = [];
    public function __construct()
    {
        $this->register('txt', new \_PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\TextDescriptor())->register('xml', new \_PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\XmlDescriptor())->register('json', new \_PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\JsonDescriptor())->register('md', new \_PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\MarkdownDescriptor());
    }
    /**
     * Describes an object if supported.
     *
     * Available options are:
     * * format: string, the output format name
     * * raw_text: boolean, sets output type as raw
     *
     * @param object $object
     *
     * @throws InvalidArgumentException when the given format is not supported
     */
    public function describe(\_PhpScoperef870243cfdb\Symfony\Component\Console\Output\OutputInterface $output, $object, array $options = [])
    {
        $options = \array_merge(['raw_text' => \false, 'format' => 'txt'], $options);
        if (!isset($this->descriptors[$options['format']])) {
            throw new \_PhpScoperef870243cfdb\Symfony\Component\Console\Exception\InvalidArgumentException(\sprintf('Unsupported format "%s".', $options['format']));
        }
        $descriptor = $this->descriptors[$options['format']];
        $descriptor->describe($output, $object, $options);
    }
    /**
     * Registers a descriptor.
     *
     * @param string $format
     *
     * @return $this
     */
    public function register($format, \_PhpScoperef870243cfdb\Symfony\Component\Console\Descriptor\DescriptorInterface $descriptor)
    {
        $this->descriptors[$format] = $descriptor;
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'descriptor';
    }
}
