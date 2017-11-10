<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Composer\Config;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
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
     * Return a new installed packages file using the given composer config.
     *
     * @param \Composer\Config $config
     * @return \Ellipse\Binder\InstalledPackagesFile
     */
    public static function newInstance(Config $config): InstalledPackagesFile
    {
        return new InstalledPackagesFile(
            DefinitionFile::newInstance(
                new MultiManifestFile(
                    new JsonFile(
                        new File(
                            new Filesystem(new Local('/')),
                            $config->get('vendor-dir') . '/composer/installed.json'
                        )
                    )
                )
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
