<?php declare(strict_types=1);

namespace Ellipse\Binder\Factories;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ServiceProviderFactoryInterface;

abstract class AbstractServiceProviderFactory implements ServiceProviderFactoryInterface
{
    /**
     * Return whether this factory can handle the given type of service
     * provider.
     *
     * @param string $type
     * @return bool
     */
    abstract public function canHandle(string $type): bool;

    /**
     * Return a service provider for the given value.
     *
     * @param string $value
     * @return Interop\Container\ServiceProviderInterface
     */
    abstract public function createServiceProvider(string $value): ServiceProviderInterface;

    /**
     * Delegate the service provider creation.
     *
     * @param array $definition
     * @return Interop\Container\ServiceProviderInterface
     */
    abstract public function delegate(array $definition): ServiceProviderInterface;

    /**
     * @inheritdoc
     */
    public function __invoke(array $definition): ServiceProviderInterface
    {
        $type = $definition['type'];
        $value = $definition['value'];

        if ($this->canHandle($type)) {

            return $this->createServiceProvider($value);

        }

        return $this->delegate($definition);
    }
}
