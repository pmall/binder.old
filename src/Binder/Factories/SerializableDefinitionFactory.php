<?php declare(strict_types=1);

namespace Ellipse\Binder\Factories;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\SerializableDefinition;

class SerializableDefinitionFactory implements DefinitionFactoryInterface
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Factories\DefinitionFactoryInterface
     */
    private $delegate;

    /**
     * Set up a serializable definition factory with the given delegate.
     *
     * @param \Ellipse\Binder\Factories\DefinitionFactoryInterface
     */
    public function __construct(DefinitionFactoryInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(array $definition): DefinitionInterface
    {
        $definition = ($this->delegate)($definition);

        return new SerializableDefinition($definition);
    }
}
