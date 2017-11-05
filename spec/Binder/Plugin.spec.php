<?php

require __DIR__ . '/../Fixtures/definition.php';

use function Eloquent\Phony\Kahlan\mock;

use Composer\Composer;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;

use Ellipse\Binder\Plugin;
use Ellipse\Binder\Project;
use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\InstalledPackageFile;
use Ellipse\Binder\ServiceProviderCollection;

describe('Plugin', function () {

    beforeEach(function () {

        $composer = mock(Composer::class);
        $this->config = mock(Config::class);
        $this->io = mock(IOInterface::class);

        $composer->getConfig->returns($this->config);

        $this->plugin = new Plugin;

        $this->plugin->activate($composer->get(), $this->io->get());

    });

    it('should implement PluginInterface', function () {

        expect($this->plugin)->toBeAnInstanceOf(PluginInterface::class);

    });

    it('should implement EventSubscriberInterface', function () {

        expect($this->plugin)->toBeAnInstanceOf(EventSubscriberInterface::class);

    });

    describe('->update()', function () {

        beforeEach(function () {

            $this->project = mock(Project::class);
            $this->manifest = mock(ManifestFile::class);

            $this->project->manifest->returns($this->manifest);

            allow(Project::class)->toBe($this->project->get());

        });

        it('should update the project manifest file with the project installed package file', function () {

            $installed = mock(InstalledPackageFile::class);

            $this->project->installed->returns($installed->get());

            $test = $this->plugin->update();

            $this->manifest->updateWith->calledWith($installed);

        });

        context('when the project manifest file ->updateWith() method returns true', function () {

            beforeEach(function () {

                $this->manifest->updateWith->returns(true);

            });

            it('should return true', function () {

                $test = $this->plugin->update();

                expect($test)->toBeTruthy();

            });

            it('should output the new service provider definitions', function () {

                $definitions = definitions(['App\\SomeClass', 'App\\SomeOtherClass']);

                $this->manifest->definitions->returns($definitions);

                $test = $this->plugin->update();

                $this->io->write->calledWith(json_encode($definitions, JSON_PRETTY_PRINT), true);

            });

        });

        context('when the project manifest file ->updateWith() method returns false', function () {

            it('should return false', function () {

                $this->manifest->updateWith->returns(false);

                $test = $this->plugin->update();

                expect($test)->toBeFalsy();

            });

        });

    });

});
