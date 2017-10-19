<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;

use Ellipse\Binder;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * The composer instance.
     *
     * @var \Composer\Composer
     */
    private $composer;

    /**
     * The io interface.
     *
     * @var \Composer\IO\IOInterface
     */
    private $io;

    /**
     * @inheritdoc
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'post-install-cmd' => 'generate',
            'post-update-cmd' => 'generate',
        ];
    }

    /**
     * Event handler to generate the compiled file.
     *
     * @return bool
     */
    public function generate(): bool
    {
        $vendor = $this->composer->getConfig()->get('vendor-dir');

        $root = realpath($vendor . '/..');

        return Binder::newInstance($root)->writeBindings();
    }
}
