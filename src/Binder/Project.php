<?php declare(strict_types=1);

namespace Ellipse\Binder;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class Project
{
    /**
     * The filesystem to use.
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    private $filesystem;

    /**
     * Return a project with the given root path.
     *
     * @param string $root
     * @return Ellipse\Binder\Project
     */
    public static function newInstance(string $root): Project
    {
        $filesystem = new Filesystem(new Local($root));

        return new Project($filesystem);
    }

    /**
     * Set up a project with the given filesystem.
     *
     * @param \League\Flysystem\FilesystemInterface
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Return the project manifest file.
     *
     * @return \Ellipse\Binder\ManifestFile
     */
    public function manifest(): ManifestFile
    {
        return new ManifestFile(
            new JsonFile(
                $this->filesystem->get('composer.json')
            )
        );
    }

    /**
     * Return the project installed package file.
     *
     * @return \Ellipse\Binder\InstalledPackageFile
     */
    public function installed(): InstalledPackageFile
    {
        return new InstalledPackageFile(
            new JsonFile(
                $this->filesystem->get('vendor/composer/installed.json')
            )
        );
    }
}
