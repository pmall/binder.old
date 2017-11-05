<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Factories\ClassServiceProviderFactory;
use Ellipse\Binder\Factories\VoidServiceProviderFactory;
use Ellipse\Binder\Exceptions\ServiceProviderDefinitionNotValidException;

class ServiceProviderFactory implements ServiceProviderFactoryInterface
{
    /**
     * The type key value of a service provider definition.
     *
     * @var string
     */
    const KEY_TYPE = 'type';

    /**
     * The value key value of a service provider definition.
     *
     * @var string
     */
    const KEY_VALUE = 'value';

    /**
     * The service provider factory the creation is delegated.
     *
     * @var \Ellipse\Binder\ServiceProviderFactoryInterface
     */
    private $delegate;

    /**
     * Return a service provider factory.
     *
     * @return \Ellipse\Binder\ServiceProviderFactory
     */
    public static function newInstance()
    {
        return new ServiceProviderFactory(
            new ClassServiceProviderFactory(
                new VoidServiceProviderFactory
            )
        );
    }

    /**
     * Set up a service provider factory with the given factory as delegate.
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
    public function __invoke(array $definition): ServiceProviderInterface
    {
        $keys = array_keys($definition);

        $length = count($keys);
        $type = in_array(self::KEY_TYPE, $keys);
        $value = in_array(self::KEY_VALUE, $keys);

        if ($length && $type && $value) {

            return ($this->delegate)($definition);

        }

        throw new ServiceProviderDefinitionNotValidException($definition);
    }
}
