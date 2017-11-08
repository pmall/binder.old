<?php declare(strict_types=1);

namespace Ellipse\Binder;

use League\Flysystem\File;

use Ellipse\Binder\Files\JsonFile;
use Ellipse\Binder\Files\DefinitionFile;
use Ellipse\Binder\Files\MultiManifestFile;

class InstalledPackagesFile
{
    /**
     * The definition file.
     *
     * @var \Ellipse\Binder\Files\DefinitionFile
     */
    private $file;

    /**
     * Return a new installed packages file with the given file and definition
     * factory.
     *
     * @param \Ellipse\Binder\Files\DefinitionFile  $file
     * @param \Ellipse\Binder\DefinitionFactory     $factory
     * @return \Ellipse\Binder\InstalledPackagesFile
     */
    public static function newInstance(File $file, DefinitionFactory $factory): InstalledPackagesFile
    {
        return new InstalledPackagesFile(
            new DefinitionFile(
                new MultiManifestFile(
                    new JsonFile(
                        $file
                    )
                ),
                $factory
            )
        );
    }

    /**
     * Set up an installed packages file with the given definition file.
     *
     * @param \Ellipse\Binder\Files\DefinitionFile $file
     */
    public function __construct(DefinitionFile $file)
    {
        $this->file = $file;
    }

    /**
     * Return the definitions contained in the installed packages file.
     *
     * @return array
     */
    public function definitions(): array
    {
        return $this->file->definitions();
    }
}
