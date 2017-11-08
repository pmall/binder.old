<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Ellipse\Binder\Factories\DefinitionFactoryInterface;
use Ellipse\Binder\Factories\SerializableDefinitionFactory;
use Ellipse\Binder\Factories\ClassDefinitionFactory;
use Ellipse\Binder\Factories\UnknownTypeDefinitionFactory;
use Ellipse\Binder\Definitions\DefinitionInterface;

class DefinitionFactory implements DefinitionFactoryInterface
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Factories\DefinitionFactoryInterface
     */
    private $delegate;

    /**
     * Return a new definition factory.
     *
     * @return \Ellipse\Binder\DefinitionFactory
     */
    public static function newInstance(): DefinitionFactory
    {
        return new DefinitionFactory(
            new SerializableDefinitionFactory(
                new ClassDefinitionFactory(
                    new UnknownTypeDefinitionFactory
                )
            )
        );
    }

    /**
     * Set up a definition factory with the given delegate.
     *
     * @param \Ellipse\Binder\Factories\DefinitionFactoryInterface $delegate
     */
    public function __construct(DefinitionFactoryInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * Return a new definition from the given data by proxying the delegate.
     *
     * @param array $data
     * @return \Ellipse\Binder\Definitions\DefinitionInterface
     */
    public function __invoke(array $data): DefinitionInterface
    {
        return ($this->delegate)($data);
    }
}
