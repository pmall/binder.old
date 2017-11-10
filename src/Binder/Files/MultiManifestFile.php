<?php declare(strict_types=1);

namespace Ellipse\Binder\Files;

use LogicException;

class MultiManifestFile implements ManifestFileInterface
{
    /**
     * The json file.
     *
     * @var \Ellipse\Binder\JsonFile
     */
    private $file;

    /**
     * Set up a multi manifest file with the given json file.
     *
     * @param \Ellipse\Binder\JsonFile $file
     */
    public function __construct(JsonFile $file)
    {
        $this->file = $file;
    }

    /**
     * @inheritdoc
     */
    public function read(): array
    {
        $data = $this->file->read();

        return array_reduce($data, function ($reduced, $data) {

            $definitions = $data['extra'][self::BINDINGS_KEY] ?? [];

            return array_merge($reduced, $definitions);

        }, []);
    }

    /**
     * @inheritdoc
     */
    public function write(array $definitions): bool
    {
        throw new LogicException;
    }
}
