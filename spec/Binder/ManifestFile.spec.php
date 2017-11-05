<?php

require __DIR__ . '/../Fixtures/definition.php';

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Binder\JsonFile;
use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\DefinitionFileInterface;
use Ellipse\Binder\ServiceProviderCollection;

describe('ManifestFile', function () {

    beforeEach(function () {

        $this->json = mock(JsonFile::class);

        $this->manifest = new ManifestFile($this->json->get());

    });

    it('should implement DefinitionFileInterface', function () {

        expect($this->manifest)->toBeAnInstanceOf(DefinitionFileInterface::class);

    });

    describe('->definitions()', function () {

        it('should return the service provider definitions contained in the file', function () {

            $definitions = definitions(['App\\SomeClass', 'App\\SomeOtherClass']);

            $data = [
                'extra' => [
                    DefinitionFileInterface::BINDINGS_KEY => $definitions,
                ],
            ];

            $this->json->read->returns($data);

            $test = $this->manifest->definitions();

            expect($test)->toEqual($definitions);

        });

    });

    describe('->updateWith()', function () {

        beforeEach(function () {

            $this->file = mock(DefinitionFileInterface::class);

        });

        it('should write the manifest to the file with the service provider definitions from the given file', function () {

            $definitions = definitions(['App\\SomeOtherClass', 'App\\YetSomeOtherClass']);

            $before = [
                'key' => 'value',
                'extra' => [
                    DefinitionFileInterface::BINDINGS_KEY => definitions(['App\\SomeClass']),
                ],
            ];

            $after = [
                'key' => 'value',
                'extra' => [
                    DefinitionFileInterface::BINDINGS_KEY => $definitions,
                ],
            ];

            $this->json->read->returns($before);
            $this->file->definitions->returns($definitions);

            $test = $this->manifest->updateWith($this->file->get());

            $this->json->write->calledWith($after);

        });

        context('when the file ->write() method returns true', function () {

            it('should return true', function () {

                $this->json->write->returns(true);

                $test = $this->manifest->updateWith($this->file->get());

                expect($test)->toBeTruthy();

            });

        });

        context('when the file ->write() method returns false', function () {

            it('should return false', function () {

                $this->json->write->returns(false);

                $test = $this->manifest->updateWith($this->file->get());

                expect($test)->toBeFalsy();

            });

        });

    });

});
