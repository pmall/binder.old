<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

class DefinitionWithClassType implements ClassDefinitionInterface
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Definitions\DefinitionInterface
     */
    private $delegate;

    /**
     * The fallback.
     *
     * @var \Ellipse\Binder\Definitions\DefinitionInterface
     */
    private $fallback;

    /**
     * Return a definition with class type with the given data and fallback.
     *
     * @param array                                             $data
     * @param \Ellipse\Binder\Definitions\DefinitionInterface   $fallback
     * @return \Ellipse\Binder\Definitions\DefinitionWithClassType
     */
    public static function newInstance(array $data, DefinitionInterface $fallback): DefinitionWithClassType
    {
        return new DefinitionWithClassType(
            new ValidClassDefinition(
                new ExistingClassDefinition(
                    new ClassDefinition(
                        $data
                    )
                )
            ),
            $fallback
        );
    }

    /**
     * Set up a definition with class type with the given delegate and fallback.
     *
     * @param \Ellipse\Binder\Definitions\ClassDefinitionInterface  $delegate
     * @param \Ellipse\Binder\Definitions\DefinitionInterface       $fallback
     */
    public function __construct(ClassDefinitionInterface $delegate, DefinitionInterface $fallback)
    {
        $this->delegate = $delegate;
        $this->fallback = $fallback;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $data = $this->delegate->toArray();

        return $data[self::TYPE_KEY] != self::TYPE_VALUE
            ? $this->fallback->toArray()
            : $data;
    }

    /**
     * @inheritdoc
     */
    public function toServiceProvider(): ServiceProviderInterface
    {
        $data = $this->delegate->toArray();

        return $data[self::TYPE_KEY] == self::TYPE_VALUE
            ? $this->delegate->toServiceProvider()
            : $this->fallback->toServiceProvider();
    }
}
