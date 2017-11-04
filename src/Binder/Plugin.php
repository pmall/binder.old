<?php declare(strict_types=1);

namespace Ellipse\Binder;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;

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
            'post-install-cmd' => 'update',
            'post-update-cmd' => 'update',
        ];
    }

    /**
     * Event handler updating the project manifest file.
     *
     * @return bool
     */
    public function update(): bool
    {
        $vendor = $this->composer->getConfig()->get('vendor-dir');

        $root = realpath($vendor . '/..');

        $project = Project::newInstance($root);

        $manifest = $project->manifest();
        $installed = $project->installed();

        $success = $manifest->updateWith($installed);

        if ($success) {

            $definitions = $manifest->definitions();

            $this->io->write('Service provider auto-discovery:', true);
            $this->io->write(json_encode($definitions, JSON_PRETTY_PRINT), true);

        }

        return $success;
    }
}
