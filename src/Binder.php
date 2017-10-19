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
    public static function newInstance(string $root): Binder
    {
        $parser = Parser::newInstance($root);
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

        $root = realpath($vendor . '/..');

        return Binder::newInstance($root)->writeBindings();
    }

    /**
     * Return an array of service providers from the given root path.
     *
     * @param string $root
     * @return array
     */
    public static function getServiceProviders(string $root): array
    {
        return Binder::newInstance($root)->readBindings();
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
     * Return a list of service providers from the composer file extra field.
     *
     * @return array
     */
    public function readBindings(): array
    {
        $data = $this->parser->read('composer.json');

        $classes = $data['extra']['binder']['providers'] ?? [];

        return array_map($this->factory, $classes);
    }

    /**
     * Write the installed packages bindings to the composer file extra field.
     *
     * @return bool
     */
    public function writeBindings(): bool
    {
        $data = $this->parser->read('composer.json');
        $manifests = $this->parser->read('vendor/composer/installed.json');

        $providers = array_map(function ($manifest) {

            return $manifest['extra']['binder']['provider'] ?? null;

        }, $manifests);

        $data['extra']['binder']['providers'] = array_values(array_filter($providers));

        return $this->parser->write('composer.json', $data);
    }
}
