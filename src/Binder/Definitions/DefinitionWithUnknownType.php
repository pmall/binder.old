<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

use \Ellipse\Binder\Definitions\Exceptions\DefinitionTypeUnknownException;

class DefinitionWithUnknownType implements DefinitionInterface
{
    /**
     * The definition data.
     *
     * @var array
     */
    private $data;

    /**
     * Set up a definition with unknown type with the given definition data.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function toServiceProvider(): ServiceProviderInterface
    {
        throw new DefinitionTypeUnknownException($this->data);
    }
}
