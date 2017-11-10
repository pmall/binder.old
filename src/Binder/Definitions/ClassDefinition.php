<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

class ClassDefinition implements ClassDefinitionInterface
{
    /**
     * The data.
     *
     * @var array $data
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
        $class = $this->data[self::CLASS_KEY];

        return new $class;
    }
}
