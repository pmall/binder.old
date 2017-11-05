<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Exceptions\InvalidServiceProviderDefinitionException;

class ServiceProviderCollection
{
    /**
     * The manifest file containing the service provider definitions.
     *
     * @var \Ellipse\Binder\ManifestFile
     */
    private $manifest;

    /**
     * The service provider factory.
     *
     * @var \Ellipse\Binder\ServiceProviderFactory
     */
    private $factory;

    /**
     * Return a new ServiceProviderCollection from the given manifest file.
     *
     * @param \Ellipse\Binder\ManifestFile
     */
    public static function newInstance(ManifestFile $manifest): ServiceProviderCollection
    {
        $factory = ServiceProviderFactory::newInstance();

        return new ServiceProviderCollection($manifest, $factory);
    }

    /**
     * Set up a service provider collection from the given manifest file and
     * the given service provider factory.
     *
     * @param \Ellipse\Binder\ManifestFile              $manifest
     * @param \Ellipse\Binder\ServiceProviderFactory    $factory
     */
    public function __construct(ManifestFile $manifest, ServiceProviderFactory $factory)
    {
        $this->manifest = $manifest;
        $this->factory = $factory;
    }

    /**
     * Return the service provider collection as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $definitions = $this->manifest->definitions();

        return array_map($this->factory, $definitions);
    }
}
