<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Exceptions\DefinitionTypeMissingException;
use Ellipse\Binder\Exceptions\DefinitionTypeNotValidException;

class UnknownTypeDefinition implements DefinitionInterface
{
    /**
     * The definition data.
     *
     * @var array
     */
    private $data;

    /**
     * Set up an unknown type definition with the given data.
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
        $type = $this->data['type'] ?? null;

        if (is_null($type)) {

            throw new DefinitionTypeMissingException($this->data);

        }

        throw new DefinitionTypeNotValidException($type);
    }
}
