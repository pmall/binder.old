<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Composer\Script\Event;

class Binder
{
    private $parser;
    private $factory;

    public static function getInstance(string $root): Binder
    {
        $parser = Parser::getInstance($root);
        $factory = function ($class) { return new $class; };

        return new Binder($parser, $factory);
    }

    public static function getServiceProviders(string $path): array
    {
        [$root, $compiled] = array_values(pathinfo($path));

        $binder = Binder::getInstance($root);

        return $binder->readCompiledFile($compiled);
    }

    public static function generate(Event $event): bool
    {
        $vendor = $event->getComposer()->getConfig()->get('vendor-dir');
        $root = realpath($vendor . '/../');
        $installed = './vendor/composer/installed.json';
        $compiled = $event->getArguments()[0] ?? './bindings.json';

        $binder = Binder::getInstance($root);

        return $binder->writeCompiledFile($installed, $compiled);
    }

    public function __construct(Parser $parser, callable $factory)
    {
        $this->parser = $parser;
        $this->factory = $factory;
    }

    public function readCompiledFile(string $compiled): array
    {
        $data = $this->parser->read($compiled);

        $classes = $data['providers'] ?? [];

        return array_map($this->factory, $classes);
    }

    /**
     * Read service providers provided given installed file and write a compiled
     * file to the given path.
     *
     * @param string $installed
     * @param string $compiled
     * @return bool
     */
    public function writeCompiledFile(string $installed, string $compiled): bool
    {
        $manifests = $this->parser->read($installed);

        $providers = array_map(function ($manifest) {

            return $manifest['extra']['binder']['provider'] ?? null;

        }, $manifests);

        $providers = array_values(array_filter($providers));

        return $this->parser->write($compiled, ['providers' => $providers]);
    }
}
