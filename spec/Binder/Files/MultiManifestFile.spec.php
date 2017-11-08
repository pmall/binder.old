<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Binder\Files\JsonFile;
use Ellipse\Binder\Files\ManifestFileInterface;
use Ellipse\Binder\Files\MultiManifestFile;

describe('MultiManifestFile', function () {

    beforeEach(function () {

        $this->json = mock(JsonFile::class);

        $this->manifest = new MultiManifestFile($this->json->get());

    });

    it('should implement ManifestFileInterface', function () {

        expect($this->manifest)->toBeAnInstanceOf(ManifestFileInterface::class);

    });

    describe('->read()', function () {

        it('should return the definitions contained in the json file', function () {

            $data1 = ['key1' => 'value1'];
            $data2 = ['key2' => 'value2'];

            $data = [
                [],
                [
                    'extra' => [
                        ManifestFileInterface::BINDINGS_KEY => $data1,
                    ],
                ],
                [
                    'extra' => [
                        ManifestFileInterface::BINDINGS_KEY => $data2,
                    ],
                ],
            ];

            $this->json->read->returns($data);

            $test = $this->manifest->read();

            expect($test)->toEqual(array_merge($data1, $data2));

        });

    });

    describe('->write()', function () {

        it('should throw a LogicException', function () {

            $data = [['key1' => 'value1'], ['key2' => 'value2']];

            $test = function () use ($data) {

                $this->manifest->write($data);

            };

            $exception = new LogicException;

            expect($test)->toThrow($exception);

        });

    });

});
