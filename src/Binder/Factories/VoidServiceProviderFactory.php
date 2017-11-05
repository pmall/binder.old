<?php declare(strict_types=1);

namespace Ellipse\Binder\Factories;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ServiceProviderFactoryInterface;
use Ellipse\Binder\Exceptions\ServiceProviderTypeNotValidException;

class VoidServiceProviderFactory implements ServiceProviderFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(array $definition): ServiceProviderInterface
    {
        throw new ServiceProviderTypeNotValidException($definition['type']);
    }
}
