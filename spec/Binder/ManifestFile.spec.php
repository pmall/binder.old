<?php

use function Eloquent\Phony\Kahlan\mock;

use League\Flysystem\File;

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

            $file = mock(File::class)->get();

            $test = ManifestFile::newInstance($file);

            expect($test)->toBeAnInstanceOf(ManifestFile::class);

        });

    });

    describe('->definitions()', function () {

        it('should proxy the definition file ->definitions() method', function () {

            $definitions = [
                mock(DefinitionInterface::class)->get(),
                mock(DefinitionInterface::class)->get(),
            ];

            $this->file->definitions->returns($definitions);

            $test = $this->manifest->definitions();

            expect($test)->toEqual($definitions);

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
