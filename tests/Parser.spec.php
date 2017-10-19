<?php

use VirtualFileSystem\FileSystem as Vfs;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Vfs\VfsAdapter;
use League\Flysystem\FileNotFoundException;

use Ellipse\Binder\Parser;

describe('Parser', function () {

    beforeEach(function () {

        $adapter = new VfsAdapter(new Vfs);
        $this->filesystem = new Filesystem($adapter);

        $this->parser = new Parser($this->filesystem);

    });

    describe('::newInstance()', function () {

        it('should return a parser using a local filesystem with the given root', function () {

            $test = Parser::newInstance(sys_get_temp_dir());

            expect($test)->to->be->an->instanceof(Parser::class);

        });

    });

    describe('->read()', function () {

        it('should return an array from the content of the given json file path', function () {

            $data = ['k1' => 'v1', 'k2' => 'v2'];

            $this->filesystem->write('/test', json_encode($data));

            $test = $this->parser->read('/test');

            expect($test)->to->be->equal($data);

        });

        it('should fail when the given file does not exist', function () {

            expect([$this->parser, 'read'])->with('/test')
                ->to->throw(FileNotFoundException::class);

        });

    });

    describe('->write()', function () {

        it('should write the given array to the contents of the given json file path', function () {

            $data = ['k1' => 'v1', 'k2' => 'v2'];

            $write = $this->parser->write('/test', $data);

            $contents = $this->filesystem->read('/test');

            $test = json_decode($contents, true);

            expect($test)->to->be->equal($data);
            expect($write)->to->be->true();

        });

    });

});
