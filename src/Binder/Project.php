<?php declare(strict_types=1);

namespace Ellipse\Binder;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class Project
{
    /**
     * The filesystem.
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    private $filesystem;

    /**
     * The definition factory.
     *
     * @var \Ellipse\Binder\DefinitionFactory
     */
    private $factory;

    /**
     * Return a new project with the given root path.
     *
     * @param string $root
     * @return \Ellipse\Binder\Project
     */
    public static function newInstance(string $root): Project
    {
        $filesystem = new Filesystem(new Local($root));
        $factory = DefinitionFactory::newInstance();

        return new Project($filesystem, $factory);
    }

    /**
     * Set up a Project with the given filesystem and definition factory.
     *
     * @param \League\Flysystem\FilesystemInterface $filesystem
     * @param \Ellipse\Binder\DefinitionFactory     $factory
     */
    public function __construct(FilesystemInterface $filesystem, DefinitionFactory $factory)
    {
        $this->filesystem = $filesystem;
        $this->factory = $factory;
    }

    /**
     * Return the project manifest file.
     *
     * @return \Ellipse\Binder\ManifestFile
     */
    public function manifest(): ManifestFile
    {
        return ManifestFile::newInstance(
            $this->filesystem->get('composer.json'),
            $this->factory
        );
    }

    /**
     * Return the project installed package file.
     *
     * @return \Ellipse\Binder\InstalledPackagesFile
     */
    public function installed(): InstalledPackagesFile
    {
        return InstalledPackagesFile::newInstance(
            $this->filesystem->get('vendor/composer/installed.json'),
            $this->factory
        );
    }
}
