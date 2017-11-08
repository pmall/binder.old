<?php declare(strict_types=1);

namespace Ellipse\Binder\Factories;

use Ellipse\Binder\Definitions\DefinitionInterface;

interface DefinitionFactoryInterface
{
    /**
     * Return a definition from the given data.
     *
     * @param array $data
     * @return \Ellipse\Binder\Definitions\DefinitionInterface
     */
    public function __invoke(array $definition): DefinitionInterface;
}
