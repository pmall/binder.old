<?php

use League\Flysystem\FilesystemInterface;

use Ellipse\Binder;

describe('Binder', function () {

    beforeEach(function () {

        $this->filesystem = Mockery::mock(FilesystemInterface::class);

        $this->binder = new Binder($this->filesystem);

    });

    describe('::newInstance()', function () {

        it('should return a Binder', function () {

            $test = Binder::newInstance(sys_get_temp_dir());

            expect($test)->to->be->an->instanceof(Binder::class);

        });

    });

    describe('->readBindings()', function () {

        it('should return service providers from the composer.json file', function () {

            class A {};
            class B {};

            $data = ['extra' => ['binder' => ['providers' => ['A', 'B']]]];

            $this->filesystem->shouldReceive('read')->once()
                ->with('composer.json')
                ->andReturn(json_encode($data));

            $test = $this->binder->readBindings();

            expect($test)->to->be->an('array');
            expect($test)->to->have->length(2);
            expect($test[0])->to->be->an->instanceof(A::class);
            expect($test[1])->to->be->an->instanceof(B::class);

        });

        it('should return an empty array when there is no service provider in the composer.json file', function () {

            $this->filesystem->shouldReceive('read')->once()
                ->with('composer.json')
                ->andReturn('');

            $test = $this->binder->readBindings();

            expect($test)->to->be->equal([]);

        });

    });

    describe('->collectBindings()', function () {

        beforeEach(function () {

            $manifests = [
                [],
                ['extra' => ['binder' => ['provider' => 'A']]],
                ['extra' => []],
                ['extra' => ['binder' => []]],
                ['extra' => ['binder' => ['provider' => 'B']]],
            ];

            $this->filesystem->shouldReceive('read')->once()
                ->with('vendor/composer/installed.json')
                ->andReturn(json_encode($manifests));

        });

        it('should return the service provider classes provided by the installed packages', function () {

            $test = $this->binder->collectBindings();

            expect($test)->to->be->equal(['A', 'B']);

        });

    });

    describe('->writeBindings()', function () {

        it('should return true when the given list of classes is empty', function () {

            $test = $this->binder->writeBindings([]);

            expect($test)->to->be->true();

        });

        it('should return true when the filesystem successfully wrote the given classes to the composer.json file', function () {

            $old = json_encode(['type' => 'library']);
            $new = json_encode(['type' => 'library', 'extra' => ['binder' => ['providers' => ['A', 'B']]]], 448);

            $this->filesystem->shouldReceive('read')->once()
                ->with('composer.json')
                ->andReturn($old);

            $this->filesystem->shouldReceive('put')->once()
                ->with('composer.json', $new)
                ->andReturn(true);

            $test = $this->binder->writeBindings(['A', 'B']);

            expect($test)->to->be->true();

        });

        it('should return false when the filesystem failed to write the given classes to the composer.json file', function () {

            $old = json_encode(['type' => 'library']);
            $new = json_encode(['type' => 'library', 'extra' => ['binder' => ['providers' => ['A', 'B']]]], 448);

            $this->filesystem->shouldReceive('read')->once()
                ->with('composer.json')
                ->andReturn($old);

            $this->filesystem->shouldReceive('put')->once()
                ->with('composer.json', $new)
                ->andReturn(false);

            $test = $this->binder->writeBindings(['A', 'B']);

            expect($test)->to->be->false();

        });

    });

});
