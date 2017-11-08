<?php declare(strict_types=1);

namespace Ellipse\Binder\Files;

class SingleManifestFile implements ManifestFileInterface
{
    /**
     * The json file.
     *
     * @var \Ellipse\Binder\JsonFile
     */
    private $file;

    /**
     * Set up a single manifest file with the given json file.
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

        return $data['extra'][self::BINDINGS_KEY] ?? [];
    }

    /**
     * @inheritdoc
     */
    public function write(array $definitions): bool
    {
        $data = $this->file->read();

        $data['extra'][self::BINDINGS_KEY] = $definitions;

        return $this->file->write($data);
    }
}
