<?php declare(strict_types=1);

namespace Ellipse\Binder\Files;

use League\Flysystem\File;

class JsonFile
{
    /**
     * The file.
     *
     * @var \League\Flysystem\File
     */
    private $file;

    /**
     * Set up a json file with the given file.
     *
     * @param \League\Flysystem\File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Return the json file contents as an array.
     *
     * @return array
     */
    public function read(): array
    {
        $contents = $this->file->read();

        return json_decode($contents, true);
    }

    /**
     * Encode the given array as json with the given options and write it to the
     * file.
     *
     * @param array $data
     * @param int   $options
     * @return bool
     */
    public function write(array $data, int $options = 448): bool
    {
        $contents = json_encode($data, $options);

        return $this->file->put($contents);
    }
}
