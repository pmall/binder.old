<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\Exceptions\ServiceProviderClassNotFoundException;

class ExistingClassDefinition implements ClassDefinitionInterface
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Definitions\DefinitionInterface
     */
    private $delegate;

    /**
     * Set up an existing class definition with the given delegate.
     *
     * @param \Ellipse\Binder\Definitions\ClassDefinitionInterface $delegate
     */
    public function __construct(ClassDefinitionInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->delegate->toArray();
    }

    /**
     * @inheritdoc
     */
    public function toServiceProvider(): ServiceProviderInterface
    {
        $data = $this->delegate->toArray();

        $class = $data[self::CLASS_KEY];

        if (class_exists($class)) {

            return $this->delegate->toServiceProvider();

        }

        throw new ServiceProviderClassNotFoundException($class);
    }
}
