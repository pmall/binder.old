<?php declare(strict_types=1);

namespace Ellipse\Binder\Files;

use Ellipse\Binder\DefinitionFactory;

class DefinitionFile
{
    /**
     * The manifest file.
     *
     * @var \Ellipse\Binder\Files\ManifestFileInterface
     */
    private $file;

    /**
     * The definition factory.
     *
     * @var \Ellipse\Binder\DefinitionFactory
     */
    private $factory;

    /**
     * Set up a definition file with the given manifest file and definition
     * factory.
     *
     * @param \Ellipse\Binder\Files\ManifestFileInterface
     * @param \Ellipse\Binder\DefinitionFactory
     */
    public function __construct(ManifestFileInterface $file, DefinitionFactory $factory)
    {
        $this->file = $file;
        $this->factory = $factory;
    }

    /**
     * Return an array of definitions from the manifest file contents.
     *
     * @return array
     */
    public function definitions(): array
    {
        $data = $this->file->read();

        return array_map($this->factory, $data);
    }

    /**
     * Update the manifest file contents with the given array of definitions.
     *
     * @param array
     * @return bool
     */
    public function updateWith(array $definitions): bool
    {
        $data = array_map(function ($definition) {

            return $definition->toArray();

        }, $definitions);

        return $this->file->write($data);
    }
}
