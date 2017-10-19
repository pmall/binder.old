<?php declare(strict_types=1);

namespace Ellipse;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class Binder
{
    /**
     * The filesystem to use.
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    private $filesystem;

    /**
     * Return a binder instance with the given project root path.
     *
     * @param string $root
     * @return Ellipse\Binder
     */
    public static function newInstance(string $root): Binder
    {
        $filesystem = new Filesystem(new Local($root));

        return new Binder($filesystem);
    }

    /**
     * Return an array of service providers using the given root path.
     *
     * @param string $root
     * @return array
     */
    public static function getServiceProviders(string $root): array
    {
        return Binder::newInstance($root)->readBindings();
    }

    /**
     * Set up a binder with the given filesystem.
     *
     * @param \League\Flysystem\FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Return a list of service providers from the composer file extra field.
     *
     * @return array
     */
    public function readBindings(): array
    {
        $contents = $this->filesystem->read('composer.json');

        $data = json_decode($contents, true);

        $classes = $data['extra']['binder']['providers'] ?? [];

        $factory = function ($class) { return new $class; };

        return array_map($factory, $classes);
    }

    /**
     * Return the list of service provider classes provided by the installed
     * packages.
     *
     * @return array
     */
    public function collectBindings(): array
    {
        $contents = $this->filesystem->read('vendor/composer/installed.json');

        $manifests = json_decode($contents, true);

        $classes = array_map(function ($manifest) {

            return $manifest['extra']['binder']['provider'] ?? null;

        }, $manifests);

        return array_values(array_filter($classes));
    }

    /**
     * Write the given service provider classes to the composer.json extra
     * field.
     *
     * @param array $classes
     * @return bool
     */
    public function writeBindings(array $classes): bool
    {
        if (count($classes) == 0) return true;

        $contents = $this->filesystem->read('composer.json');

        $data = json_decode($contents, true);

        $data['extra']['binder']['providers'] = $classes;

        $contents = json_encode($data, 448);

        return $this->filesystem->put('composer.json', $contents);
    }
}
