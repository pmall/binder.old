<?php declare(strict_types=1);

namespace Ellipse\Binder\Factories;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ServiceProviderFactoryInterface;
use Ellipse\Binder\Exceptions\ServiceProviderClassNotFoundException;

class ClassServiceProviderFactory extends AbstractServiceProviderFactory
{
    /**
     * The type of service provider handled by this factory.
     *
     * @var string
     */
    const TYPE_CLASS = 'class';

    /**
     * The service provider factory the creation is delegated.
     *
     * @var \Ellipse\Binder\Factories\ServiceProviderFactoryInterface
     */
    private $delegate;

    /**
     * Set up a class service provider factory with the given factory as
     * delegate.
     *
     * @param \Ellipse\Binder\Factories\ServiceProviderFactoryInterface $delegate
     */
    public function __construct(ServiceProviderFactoryInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * @inheritdoc
     */
    public function canHandle(string $type): bool
    {
        return $type == self::TYPE_CLASS;
    }

    /**
     * @inheritdoc
     */
    public function createServiceProvider(string $value): ServiceProviderInterface
    {
        if (class_exists($value)) {

            return new $value;

        };

        throw new ServiceProviderClassNotFoundException($value);
    }

    /**
     * @inheritdoc
     */
    public function delegate(array $definition): ServiceProviderInterface
    {
        return ($this->delegate)($definition);
    }
}
