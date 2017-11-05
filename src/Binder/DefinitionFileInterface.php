<?php declare(strict_types=1);

namespace Ellipse\Binder;

interface DefinitionFileInterface
{
    /**
     * The value of the key containing the service provider definitions.
     *
     * @var string
     */
    const BINDINGS_KEY = 'binder';

    /**
     * Return an array of service provider definitions contained in the file.
     *
     * @return array
     */
    public function definitions(): array;
}
