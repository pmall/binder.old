<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use JsonSerializable;

use Interop\Container\ServiceProviderInterface;

class SerializableDefinition implements DefinitionInterface, JsonSerializable
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Definitions\DefinitionInterface
     */
    private $delegate;

    /**
     * Set up a serializable definition with the given delegate.
     *
     * @param \Ellipse\Binder\Definitions\DefinitionInterface
     */
    public function __construct(DefinitionInterface $delegate)
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
        return $this->delegate->toServiceProvider();
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->delegate->toArray();
    }
}
