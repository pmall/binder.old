<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\stub;

use Ellipse\Binder\Definition;
use Ellipse\Binder\Files\DefinitionFile;
use Ellipse\Binder\Files\ManifestFileInterface;
use Ellipse\Binder\Definitions\DefinitionInterface;

describe('DefinitionFile', function () {

    beforeEach(function () {

        $this->manifest = mock(ManifestFileInterface::class);
        $this->factory = stub();

        $this->file = new DefinitionFile($this->manifest->get(), $this->factory);

    });

    describe('::newInstance', function () {

        it('should return a new DefinitionFile', function () {

            $test = DefinitionFile::newInstance($this->manifest->get());

            expect($test)->toBeAnInstanceOf(DefinitionFile::class);

        });

    });

    describe('->definitions()', function () {

        it('should return an array of service providers from the definitions contained in the manifest file', function () {

            $data1 = ['key1' => 'value1'];
            $data2 = ['key2' => 'value2'];

            $definition1 = mock(DefinitionInterface::class)->get();
            $definition2 = mock(DefinitionInterface::class)->get();

            $this->manifest->read->returns([$data1, $data2]);

            $this->factory->with($data1)->returns($definition1);
            $this->factory->with($data2)->returns($definition2);

            $test = $this->file->definitions();

            expect($test)->toEqual([$definition1, $definition2]);

        });

    });

    describe('->updateWith()', function () {

        beforeEach(function () {

            $definition1 = mock(DefinitionInterface::class);
            $definition2 = mock(DefinitionInterface::class);

            $this->data1 = ['key1' => 'value1'];
            $this->data2 = ['key2' => 'value2'];

            $definition1->toArray->returns($this->data1);
            $definition2->toArray->returns($this->data2);

            $this->definitions = [
                $definition1->get(),
                $definition2->get(),
            ];

        });

        it('should write the definitions from the given file to the manifest file', function () {

            $this->file->updateWith($this->definitions);

            $this->manifest->write->calledWith([$this->data1, $this->data2]);

        });

        it('should should return true when the manifest file ->write() method returns true', function () {

            $this->manifest->write->returns(true);

            $test = $this->file->updateWith($this->definitions);

            expect($test)->toBeTruthy();

        });

        it('should should return false when the manifest file ->write() method returns false', function () {

            $this->manifest->write->returns(false);

            $test = $this->file->updateWith($this->definitions);

            expect($test)->toBeFalsy();

        });

    });

});
