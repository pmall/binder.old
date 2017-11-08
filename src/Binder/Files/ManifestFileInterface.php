<?php declare(strict_types=1);

namespace Ellipse\Binder\Files;

interface ManifestFileInterface
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
    public function read(): array;

    /**
     * Write an array of service provider definitions to the file.
     *
     * @param array $definitions
     * @return bool
     */
    public function write(array $definitions): bool;
}
