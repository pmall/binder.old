<?php

use function Eloquent\Phony\Kahlan\mock;

use League\Flysystem\File;

use Ellipse\Binder\DefinitionFactory;
use Ellipse\Binder\InstalledPackagesFile;
use Ellipse\Binder\Files\DefinitionFile;
use Ellipse\Binder\Definitions\DefinitionInterface;

describe('InstalledPackagesFile', function () {

    beforeEach(function () {

        $this->file = mock(DefinitionFile::class);

        $this->installed = new InstalledPackagesFile($this->file->get());

    });

    describe('::newInstance()', function () {

        it('should return a new InstalledPackagesFile', function () {

            $file = mock(File::class)->get();
            $factory = mock(DefinitionFactory::class)->get();

            $test = InstalledPackagesFile::newInstance($file, $factory);

            expect($test)->toBeAnInstanceOf(InstalledPackagesFile::class);

        });

    });

    describe('->definitions()', function () {

        it('should proxy the definition file ->definitions() method', function () {

            $definitions = [
                mock(DefinitionInterface::class)->get(),
                mock(DefinitionInterface::class)->get(),
            ];

            $this->file->definitions->returns($definitions);

            $test = $this->installed->definitions();

            expect($test)->toEqual($definitions);

        });

    });

});
