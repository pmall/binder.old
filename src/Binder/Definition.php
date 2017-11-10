<?php declare(strict_types=1);

namespace Ellipse\Binder;

use JsonSerializable;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\DefinitionWithClassType;
use Ellipse\Binder\Definitions\DefinitionWithUnknownType;
use Ellipse\Binder\Definitions\Exceptions\DefinitionTypeMissingException;

class Definition implements DefinitionInterface, JsonSerializable
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Definitions\DefinitionInterface
     */
    private $delegate;

    /**
     * Return a new definition with the given data.
     *
     * @param array $data
     * @return \Ellipse\Binder\Definition
     */
    public static function newInstance(array $data): Definition
    {
        return new Definition(
            DefinitionWithClassType::newInstance(
                $data,
                new DefinitionWithUnknownType($data)
            )
        );
    }

    /**
     * Set up a definition with the given delegate.
     *
     * @param \Ellipse\Binder\Definitions\DefinitionInterface $delegate
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
        $data = $this->delegate->toArray();

        if (array_key_exists(self::TYPE_KEY, $data)) {

            return $this->delegate->toServiceProvider();

        }

        throw new DefinitionTypeMissingException($data);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->delegate->toArray();
    }
}
