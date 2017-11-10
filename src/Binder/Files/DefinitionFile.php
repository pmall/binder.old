<?php declare(strict_types=1);

namespace Ellipse\Binder\Files;

use Ellipse\Binder\Definition;

class DefinitionFile
{
    /**
     * The manifest file.
     *
     * @var \Ellipse\Binder\Files\ManifestFileInterface
     */
    private $manifest;

    /**
     * The definition factory.
     *
     * @var callable
     */
    private $factory;

    /**
     * Return a new definition file with the given manifest file.
     *
     * @param \Ellipse\Binder\Files\ManifestFileInterface $manifest
     * @return \Ellipse\Binder\Files\DefinitionFile
     */
    public static function newInstance(ManifestFileInterface $manifest): DefinitionFile
    {
        return new DefinitionFile($manifest, [Definition::class, 'newInstance']);
    }

    /**
     * Set up a definition file with the given manifest file and definition
     * factory.
     *
     * @param \Ellipse\Binder\Files\ManifestFileInterface   $manifest
     * @param callable                                      $factory
     */
    public function __construct(ManifestFileInterface $manifest, callable $factory)
    {
        $this->manifest = $manifest;
        $this->factory = $factory;
    }

    /**
     * Return an array of definitions from the manifest file contents.
     *
     * @return array
     */
    public function definitions(): array
    {
        $data = $this->manifest->read();

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

        return $this->manifest->write($data);
    }
}
