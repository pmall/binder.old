<?php

use function Eloquent\Phony\Kahlan\mock;

use Composer\Composer;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;

use Ellipse\Binder\Plugin;
use Ellipse\Binder\Project;
use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\InstalledPackagesFile;
use Ellipse\Binder\Definition;

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
            $this->installed = mock(InstalledPackagesFile::class);
            $this->definition1 = mock(Definition::class);
            $this->definition2 = mock(Definition::class);
            $this->definitions = [
                $this->definition1->get(),
                $this->definition2->get(),
            ];

            $this->project->manifest->returns($this->manifest);
            $this->project->installed->returns($this->installed);

            $this->installed->definitions->returns($this->definitions);

            allow(Project::class)->toBe($this->project->get());

        });

        it('should update the project manifest file with the project installed package file', function () {

            $test = $this->plugin->update();

            $this->manifest->updateWith->calledWith($this->definitions);

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

                $data1 = ['key1' => 'value1'];
                $data2 = ['key2' => 'value2'];

                $this->definition1->jsonSerialize->returns($data1);
                $this->definition2->jsonSerialize->returns($data2);

                $this->plugin->update();

                $this->definition1->jsonSerialize->called();
                $this->definition2->jsonSerialize->called();
                $this->io->write->calledWith(json_encode([$data1, $data2], JSON_PRETTY_PRINT), true);

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
