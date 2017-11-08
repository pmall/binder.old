<?php declare(strict_types=1);

namespace Ellipse\Binder;

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
     * Return a new manifest file with the given file and definition factory.
     *
     * @param \Ellipse\Binder\Files\DefinitionFile  $file
     * @param \Ellipse\Binder\DefinitionFactory     $factory
     * @return \Ellipse\Binder\ManifestFile
     */
    public static function newInstance(File $file, DefinitionFactory $factory): ManifestFile
    {
        return new ManifestFile(
            new DefinitionFile(
                new SingleManifestFile(
                    new JsonFile(
                        $file
                    )
                ),
                $factory
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
    public function definitions(): array
    {
        return $this->file->definitions();
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