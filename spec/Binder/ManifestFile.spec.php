<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\Files\DefinitionFile;
use Ellipse\Binder\Definitions\DefinitionInterface;

describe('ManifestFile', function () {

    beforeEach(function () {

        $this->file = mock(DefinitionFile::class);

        $this->manifest = new ManifestFile($this->file->get());

    });

    describe('::newInstance()', function () {

        it('should return a new ManifestFile', function () {

            $test = ManifestFile::newInstance(getcwd());

            expect($test)->toBeAnInstanceOf(ManifestFile::class);

        });

    });

    describe('->providers()', function () {

        it('should return the service providers defined in the manifest file', function () {

            $definition1 = mock(DefinitionInterface::class);
            $definition2 = mock(DefinitionInterface::class);

            $provider1 = mock(ServiceProviderInterface::class)->get();
            $provider2 = mock(ServiceProviderInterface::class)->get();

            $definition1->toServiceProvider->returns($provider1);
            $definition2->toServiceProvider->returns($provider2);

            $this->file->definitions->returns([$definition1->get(), $definition2->get()]);

            $test = $this->manifest->providers();

            expect($test)->toEqual([$provider1, $provider2]);

        });

    });

    describe('->updateWith()', function () {

        beforeEach(function () {

            $this->definitions = [
                mock(DefinitionInterface::class)->get(),
                mock(DefinitionInterface::class)->get(),
            ];

        });

        it('should proxy the definition file ->updateWith() method', function () {

            $this->manifest->updateWith($this->definitions);

            $this->file->updateWith->calledWith($this->definitions);

        });

        it('should should return true when the definition file ->updateWith() method returns true', function () {

            $this->file->updateWith->returns(true);

            $test = $this->manifest->updateWith($this->definitions);

            expect($test)->toBeTruthy();

        });

        it('should should return false when the definition file ->updateWith() method returns false', function () {

            $this->file->updateWith->returns(false);

            $test = $this->manifest->updateWith($this->definitions);

            expect($test)->toBeFalsy();

        });

    });

});
