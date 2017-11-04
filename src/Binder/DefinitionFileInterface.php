<?php declare(strict_types=1);

namespace Ellipse\Binder;

interface DefinitionFileInterface
{
    /**
     * The key value the service providers definitions are stored under.
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
