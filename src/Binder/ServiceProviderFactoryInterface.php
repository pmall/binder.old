<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Interop\Container\ServiceProviderInterface;

interface ServiceProviderFactoryInterface
{
    /**
     * Return a service provider factory from the given definition array.
     *
     * @param array $definition
     * @return \Interop\Container\ServiceProviderInterface
     * @throws \Ellipse\Binder\Exceptions\BinderExceptionInterface
     */
    public function __invoke(array $definition): ServiceProviderInterface;
}
