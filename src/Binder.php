<?php declare(strict_types=1);

namespace Ellipse;

use Ellipse\Binder\RootFilesystem;
use Ellipse\Binder\ManifestFile;

class Binder
{
    /**
     * The project ManifestFile.
     *
     * @var \Ellipse\Binder\ManifestFile
     */
    private $project;

    /**
     * Return a new binder with the given project root path.
     *
     * @param string $root
     * @return \Ellipse\Binder
     */
    public static function newInstance(string $root): Binder
    {
        $manifest = ManifestFile::newInstance($root);

        return new Binder($manifest);
    }

    /**
     * Set up a binder with the given manifest file.
     *
     * @param \Ellipse\Binder\ManifestFile $manifest
     */
    public function __construct(ManifestFile $manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * Return the service providers defined in the project manifest file.
     *
     * @return array
     */
    public function providers(): array
    {
        return $this->manifest->providers();
    }
}
