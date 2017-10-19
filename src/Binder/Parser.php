<?php declare(strict_types=1);

namespace Ellipse\Binder;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class Parser
{
    /**
     * The filesystem to use.
     *
     * @var \League\Flysystem\FilesystemInterface
     */
    private $parser;

    /**
     * Return a parser using a local filesystem with the given root.
     *
     * @param string $root
     * @return \Ellipse\Binder\Parser
     */
    public static function newInstance(string $root): Parser
    {
        $adapter = new Local($root);

        $filesystem = new Filesystem($adapter);

        return new Parser($filesystem);
    }

    /**
     * Set up a parser with the given filesystem.
     *
     * @param \League\Flysystem\FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Return an array from the content of the given json file path.
     *
     * @param string $path
     * @return array
     */
    public function read(string $path): array
    {
        $contents = $this->filesystem->read($path);

        return json_decode($contents, true);
    }

    /**
     * Return write the given array to the contents of the given json file path.
     *
     * @param string    $path
     * @param array     $data
     * @return bool
     */
    public function write(string $path, array $data): bool
    {
        $contents = json_encode($data, 448) . "\n";

        return $this->filesystem->put($path, $contents);
    }
}
