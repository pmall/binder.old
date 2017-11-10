<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

interface DefinitionInterface
{
    /**
     * The value of the key containing the definition type.
     *
     * @var string
     */
    const TYPE_KEY = 'type';

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
     * @throws \Ellipse\Binder\Definitions\Exceptions\DefinitionExceptionInterface
     */
    public function toServiceProvider(): ServiceProviderInterface;
}
