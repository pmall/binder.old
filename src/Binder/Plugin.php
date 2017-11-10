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
        $root = getcwd();
        $config = $this->composer->getConfig();

        $manifest = ManifestFile::newInstance($root);
        $installed = InstalledPackagesFile::newInstance($config);

        $definitions = $installed->definitions();

        $success = $manifest->updateWith($definitions);

        if ($success) {

            $this->io->write('Service provider auto-discovery:', true);
            $this->io->write(json_encode($definitions, JSON_PRETTY_PRINT), true);

        }

        return $success;
    }
}
