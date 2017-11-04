<?php

use function Eloquent\Phony\Kahlan\mock;

use League\Flysystem\File;

use Ellipse\Binder\JsonFile;

describe('JsonFile', function () {

    beforeEach(function () {

        $this->file = mock(File::class);

        $this->json = new JsonFile($this->file->get());

    });

    describe('->read()', function () {

        it('should return the decoded file contents', function () {

            $contents = json_encode(['key' => 'value']);

            $this->file->read->returns($contents);

            $test = $this->json->read();

            expect($test)->toEqual(['key' => 'value']);

        });

    });

    describe('->write()', function () {

        it('should encode the given data as json with the given options and write it to the file', function () {

            $data = ['key' => 'value'];

            $contents = json_encode($data, 16);

            $this->file->put->returns(true);

            $test = $this->json->write($data, 16);

            expect($test)->toBeTruthy();
            $this->file->put->calledWith($contents);

        });

        it('should use 448 as default json options', function () {

            $data = ['key' => 'value'];

            $contents = json_encode($data, 448);

            $this->file->put->returns(true);

            $test = $this->json->write($data);

            expect($test)->toBeTruthy();
            $this->file->put->calledWith($contents);

        });

        it('should return false when the file ->write() method returns false', function () {

            $this->file->put->returns(false);

            $test = $this->json->write(['key' => 'value']);

            expect($test)->toBeFalsy();

        });

    });

});
