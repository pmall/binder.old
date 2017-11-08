<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Binder\Files\JsonFile;
use Ellipse\Binder\Files\ManifestFileInterface;
use Ellipse\Binder\Files\SingleManifestFile;

describe('SingleManifestFile', function () {

    beforeEach(function () {

        $this->json = mock(JsonFile::class);

        $this->manifest = new SingleManifestFile($this->json->get());

    });

    it('should implement ManifestFileInterface', function () {

        expect($this->manifest)->toBeAnInstanceOf(ManifestFileInterface::class);

    });

    describe('->read()', function () {

        it('should return the definitions contained in the json file', function () {

            $data = ['key' => 'value'];

            $contents = [
                'extra' => [
                    ManifestFileInterface::BINDINGS_KEY => $data,
                ],
            ];

            $this->json->read->returns($contents);

            $test = $this->manifest->read();

            expect($test)->toEqual($data);

        });


    });

    describe('->write()', function () {

        beforeEach(function () {

            $this->data = [['key2' => 'value2'], ['key3' => 'value3']];

        });

        it('should write the given definition collection to the json file as an array', function () {

            $before = [
                'key' => 'value',
                'extra' => [
                    ManifestFileInterface::BINDINGS_KEY => [['key1' => 'value1']],
                ],
            ];

            $after = [
                'key' => 'value',
                'extra' => [
                    ManifestFileInterface::BINDINGS_KEY => $this->data,
                ],
            ];

            $this->json->read->returns($before);

            $this->manifest->write($this->data);

            $this->json->write->calledWith($after);

        });

        it('should return true when the json file ->write() method returns true', function () {

            $this->json->write->returns(true);

            $test = $this->manifest->write($this->data);

            expect($test)->toBeTruthy();

        });

        it('should return false when the json file ->write() method returns false', function () {

            $this->json->write->returns(false);

            $test = $this->manifest->write($this->data);

            expect($test)->toBeFalsy();

        });

    });

});
