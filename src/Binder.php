<?php declare(strict_types=1);

namespace Ellipse;

use Composer\Script\Event;

use Ellipse\Binder\Parser;

class Binder
{
    /**
     * The parser used to read json files.
     *
     * @var \Ellipse\Binder\Parser
     */
    private $parser;

    /**
     * The factory used to create service providers from their class names.
     *
     * @var callable
     */
    private $factory;

    /**
     * Return a binder instance from the given project root path.
     *
     * @param string $root
     * @return Ellipse\Binder\Binder
     */
    public static function getInstance(string $root): Binder
    {
        $parser = Parser::getInstance($root);
        $factory = function ($class) { return new $class; };

        return new Binder($parser, $factory);
    }

    /**
     * Command to generate the compiled file from a composer event.
     *
     * @param \Composer\Script\Event $event
     * @return bool
     */
    public static function generate(Event $event): bool
    {
        $vendor = $event->getComposer()->getConfig()->get('vendor-dir');

        [$root] = array_values(pathinfo($vendor));

        $installed = './vendor/composer/installed.json';
        $compiled = './bindings.json';

        $binder = Binder::getInstance($root);

        return $binder->writeCompiledFile($installed, $compiled);
    }

    /**
     * Return an array of service providers from the given compiled file
     * absolute path.
     *
     * @param string $path
     * @return array
     */
    public static function getServiceProviders(string $path): array
    {
        [$root, $compiled] = array_values(pathinfo($path));

        $binder = Binder::getInstance($root);

        return $binder->readCompiledFile($compiled);
    }

    /**
     * Set up a builder with the given parser an the given service provider
     * factory.
     *
     * @param \Ellipse\Binder\Parser    $parser
     * @param callable                  $factory
     */
    public function __construct(Parser $parser, callable $factory)
    {
        $this->parser = $parser;
        $this->factory = $factory;
    }

    /**
     * Return a list of service providers from the given compiled file path.
     *
     * @param string $compiled
     * @return array
     */
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
