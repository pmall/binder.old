<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

interface ClassDefinitionInterface extends DefinitionInterface
{
    /**
     * The type value of a class definition.
     *
     * @var string
     */
    const TYPE_VALUE = 'class';

    /**
     * The value of the key containing the class name.
     *
     * @var string
     */
    const CLASS_KEY = 'value';
}
