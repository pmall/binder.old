<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Exceptions\ClassDefinitionNotValidException;
use Ellipse\Binder\Exceptions\ServiceProviderClassNotFoundException;

class ClassDefinition implements DefinitionInterface
{
    /**
     * The value of the class type.
     *
     * @var string
     */
    const TYPE = 'class';

    /**
     * The definition data.
     *
     * @var array
     */
    private $data;

    /**
     * Set up a class definition with the given data.
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
        // Validate the number of keys.
        if (count($this->data) != 2) {

            throw new ClassDefinitionNotValidException($this->data);

        }

        // Validate the value.
        $value = $this->data['value'] ?? null;

        if (is_null($value)) {

            throw new ClassDefinitionNotValidException($this->data);

        }

        // Try to return a service provider from the value.
        if (class_exists($value)) {

            return new $value;

        }

        throw new ServiceProviderClassNotFoundException($value);
    }
}
