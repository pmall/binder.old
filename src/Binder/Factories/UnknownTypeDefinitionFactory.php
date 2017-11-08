<?php declare(strict_types=1);

namespace Ellipse\Binder\Factories;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\UnknownTypeDefinition;

class UnknownTypeDefinitionFactory implements DefinitionFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(array $definition): DefinitionInterface
    {
        return new UnknownTypeDefinition($definition);
    }
}
