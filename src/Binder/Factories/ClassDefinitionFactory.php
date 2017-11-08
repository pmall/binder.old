<?php declare(strict_types=1);

namespace Ellipse\Binder\Factories;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinition;

class ClassDefinitionFactory implements DefinitionFactoryInterface
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Factories\DefinitionFactoryInterface
     */
    private $delegate;

    /**
     * Set up a class definition factory with the given delegate.
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
        $type = $definition['type'] ?? null;

        if ($type == ClassDefinition::TYPE) {

            return new ClassDefinition($definition);

        }

        return ($this->delegate)($definition);
    }
}
