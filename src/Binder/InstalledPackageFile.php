<?php declare(strict_types=1);

namespace Ellipse\Binder;

class InstalledPackageFile implements DefinitionFileInterface
{
    /**
     * The installed package file actual json file.
     *
     * @var \Ellipse\Binder\JsonFile
     */
    private $file;

    /**
     * Set up an installed package file with the given json file.
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

        return array_reduce($data, function ($reduced, $data) {

            $definitions = $data['extra'][self::BINDINGS_KEY] ?? null;

            if (is_null($definitions)) return $reduced;

            return array_merge($reduced, $definitions);

        }, []);
    }
}
