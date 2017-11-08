<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Interop\Container\ServiceProviderInterface;

class ServiceProviderCollection
{
    /**
     * The manifest file.
     *
     * @var \Ellipse\Binder\ManifestFile
     */
    private $manifest;

    /**
     * Set up a service provider collection with the given manifest file.
     *
     * @param \Ellipse\Binder\ManifestFile $manifest
     */
    public function __construct(ManifestFile $manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * Return the service provider collection as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $definitions = $this->manifest->definitions();

        $factory = function ($definition) {

            return $definition->toServiceProvider();

        };

        return array_map($factory, $definitions);
    }
}
