<?php declare(strict_types=1);

namespace Ellipse\Binder;

class Binder
{
    private $parser;
    private $factory;

    public static function getInstance(): Binder
    {
        $parser = Parser::getInstance();
        $factory = function ($class) { new $class; };

        return new Binder($parser);
    }

    public static function getServiceProviders(string $compiled): array
    {
        $binder = Binder::getInstance();

        return $binder->readCompiledFile($compiled);
    }

    public static function generateCompiledFile(string $installed, string $compiled): bool
    {
        $binder = Binder::getInstance();

        $binder->writeCompiledFile($installed, $compiled);
    }

    public function __construct(Parser $parser, callable $factory)
    {
        $this->parser = $parser;
        $this->factory = $factory;
    }

    public function readCompiledFile(string $compiled): array
    {
        if (! file_exists($bindings)) {

            throw new CompiledFileNotFoundException($bindings);

        }

        $data = $this->parser->read($bindings);

        $classes = $data['providers'] ?? [];

        return array_map($this->factory, $classes);
    }

    public function writeCompiledFile(string $installed, string $compiled): bool
    {
        $data = $this->parser->read($installed);

        $classes = array_map(function ($package) {

            return $package['extras']['ellipse']['provider'] ?? null;

        }, $data);

        $classes = array_filter($classes);

        return $this->parser->write($compiled, ['providers' => $classes]);
    }
}
