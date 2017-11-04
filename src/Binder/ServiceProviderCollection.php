<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Exceptions\InvalidServiceProviderDefinitionException;

class ServiceProviderCollection
{
    /**
     * The value of the class definition type.
     *
     * @var string
     */
    const CLASS_TYPE = 'class';

    /**
     * The manifest file containing the service providers.
     *
     * @var \Ellipse\Binder\ManifestFile
     */
    private $manifest;

    /**
     * Set up a service provider list from the given manifest file.
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

        return array_map([$this, 'createServiceProvider'], $definitions);
    }

    /**
     * Return a service provider from the given definition.
     *
     * @param array $definition
     * @return \Interop\Container\ServiceProviderInterface
     */
    private function createServiceProvider(array $definition): ServiceProviderInterface
    {
        $type = $definition['type'] ?? null;
        $value = $definition['value'] ?? null;

        if ($type === self::CLASS_TYPE) {

            return new $value;

        }

        throw new InvalidServiceProviderDefinitionException($definition);
    }
}
