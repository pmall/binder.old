<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

interface DefinitionInterface
{
    /**
     * Return the definition as an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Return the service provider defined by this definition data.
     *
     * @return \Interop\Container\ServiceProviderInterface
     * @throws \Ellipse\Binder\Exceptions\BinderExceptionInterface
     */
    public function toServiceProvider(): ServiceProviderInterface;
}
