<?php declare(strict_types=1);

namespace Ellipse\Binder;

class ManifestFile implements DefinitionFileInterface
{
    /**
     * The manifest file json file.
     *
     * @var \Ellipse\Binder\JsonFile
     */
    private $file;

    /**
     * Set up a manifest file with the given json file.
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
    public function definitions(): array
    {
        $data = $this->file->read();

        return $data['extra'][self::BINDINGS_KEY] ?? [];
    }

    /**
     * Save the manifest file with the service provider definitions from the
     * given file.
     *
     * @param \Ellipse\Binder\DefinitionFileInterface $file
     * @return bool
     */
    public function updateWith(DefinitionFileInterface $file): bool
    {
        $data = $this->file->read();

        $data['extra'][self::BINDINGS_KEY] = $file->definitions();

        return $this->file->write($data);
    }
}
