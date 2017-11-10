<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\Exceptions\DefinitionNotValidException;

class ValidClassDefinition implements ClassDefinitionInterface
{
    /**
     * The delegate.
     *
     * @var \Ellipse\Binder\Definitions\DefinitionInterface
     */
    private $delegate;

    /**
     * Return a valid class definition with the given data and fallback.
     *
     * @param array                                             $data
     * @param \Ellipse\Binder\Definitions\DefinitionInterface   $fallback
     */
    public static function newInstance(array $data, DefinitionInterface $fallback): ValidClassDefinition
    {
        return new ValidClassDefinition(
            new ExistingClassDefinition(
                new ClassDefinition(
                    $data
                )
            )
        );
    }

    /**
     * Set up a valid class definition with the given delegate.
     *
     * @param \Ellipse\Binder\Definitions\ClassDefinitionInterface $delegate
     */
    public function __construct(ClassDefinitionInterface $delegate)
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

        $expected = [self::TYPE_KEY, self::CLASS_KEY];

        $keys = array_keys($data);

        $nb = count($expected);
        $union = count($keys) == $nb;
        $intersect = count(array_intersect($keys, $expected)) == $nb;

        if ($union && $intersect) {

            return $this->delegate->toServiceProvider();

        }

        throw new DefinitionNotValidException($expected, $data);
    }
}
