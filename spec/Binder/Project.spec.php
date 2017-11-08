<?php

use function Eloquent\Phony\Kahlan\mock;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\File;

use Ellipse\Binder\Project;
use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\InstalledPackagesFile;
use Ellipse\Binder\DefinitionFactory;

describe('Project', function () {

    beforeEach(function () {

        $this->filesystem = mock(FilesystemInterface::class);
        $this->factory = mock(DefinitionFactory::class);

        $this->project = new Project($this->filesystem->get(), $this->factory->get());

    });

    describe('::newInstance()', function () {

        it('should return a Project', function () {

            $test = Project::newInstance(sys_get_temp_dir());

            expect($test)->toBeAnInstanceOf(Project::class);

        });

    });

    describe('->manifest()', function () {

        it('should return the project manifest file', function () {

            $file = mock(File::class);

            $this->filesystem->get->returns($file);

            $test = $this->project->manifest();

            expect($test)->toBeAnInstanceOf(ManifestFile::class);
            $this->filesystem->get->calledWith('composer.json');

        });

    });

    describe('->installed()', function () {

        it('should return the project installed package file', function () {

            $file = mock(File::class);

            $this->filesystem->get->returns($file);

            $test = $this->project->installed();

            expect($test)->toBeAnInstanceOf(InstalledPackagesFile::class);
            $this->filesystem->get->calledWith('vendor/composer/installed.json');

        });

    });

});