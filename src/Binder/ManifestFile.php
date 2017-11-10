<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Composer\Factory;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\File;

use Ellipse\Binder\Files\JsonFile;
use Ellipse\Binder\Files\DefinitionFile;
use Ellipse\Binder\Files\SingleManifestFile;

class ManifestFile
{
    /**
     * The definition file.
     *
     * @var \Ellipse\Binder\Files\DefinitionFile
     */
    private $file;

    /**
     * Return a new manifest file using the given project root path.
     *
     * @param string $root
     * @return \Ellipse\Binder\ManifestFile
     */
    public static function newInstance(string $root): ManifestFile
    {
        return new ManifestFile(
            DefinitionFile::newInstance(
                new SingleManifestFile(
                    new JsonFile(
                        new File(
                            new Filesystem(new Local($root)),
                            Factory::getComposerFile()
                        )
                    )
                )
            )
        );
    }

    /**
     * Set up a manifest file with the given definition file.
     *
     * @param \Ellipse\Binder\Files\DefinitionFile $file
     */
    public function __construct(DefinitionFile $file)
    {
        $this->file = $file;
    }

    /**
     * Return the definitions contained in the manifest file.
     *
     * @return array
     */
    public function providers(): array
    {
        $definitions = $this->file->definitions();

        $factory = function ($definition) {

            return $definition->toServiceProvider();

        };

        return array_map($factory, $definitions);
    }

    /**
     * Update the manifest file contents with the given array of definitions.
     *
     * @param array
     * @return bool
     */
    public function updateWith(array $definitions): bool
    {
        return $this->file->updateWith($definitions);
    }
}
