<?php

use Ellipse\Binder;
use Ellipse\Binder\Parser;

interface BinderCallable
{
    public function __invoke();
}

describe('Binder', function () {

    beforeEach(function () {

        $this->parser = Mockery::mock(Parser::class);
        $this->factory = Mockery::mock(BinderCallable::class);

        $this->binder = new Binder($this->parser, $this->factory);

    });

    describe('::getInstance()', function () {

        it('should return a Binder', function () {

            $test = Binder::getInstance(sys_get_temp_dir());

            expect($test)->to->be->an->instanceof(Binder::class);

        });

    });

    describe('->readCompiledFile()', function () {

        it('should return service providers from the given compiled file path', function () {

            $a = new class {};
            $b = new class {};

            $this->parser->shouldReceive('read')->once()
                ->with('binder.json')
                ->andReturn(['providers' => ['A', 'B']]);

            $this->factory->shouldReceive('__invoke')->once()
                ->with('A')
                ->andReturn($a);

            $this->factory->shouldReceive('__invoke')->once()
                ->with('B')
                ->andReturn($b);

            $test = $this->binder->readCompiledFile('binder.json');

            expect($test)->to->be->equal([$a, $b]);

        });

        it('should return an empty array when no service provider is defined', function () {

            $this->parser->shouldReceive('read')->once()
                ->with('binder.json')
                ->andReturn([]);

            $test = $this->binder->readCompiledFile('binder.json');

            expect($test)->to->be->equal([]);

        });

    });

    describe('->writeCompiledFile()', function () {

        beforeEach(function () {

            $manifests = [
                [],
                ['extra' => ['binder' => ['provider' => 'A']]],
                ['extra' => []],
                ['extra' => ['binder' => []]],
                ['extra' => ['binder' => ['provider' => 'B']]],
            ];

            $this->parser->shouldReceive('read')->once()
                ->with('installed.json')
                ->andReturn($manifests);

        });

        it('should read service providers provided given installed file and write a compiled file to the given path', function () {

            $this->parser->shouldReceive('write')->once()
                ->with('binder.json', ['providers' => ['A', 'B']])
                ->andReturn(true);

            $test = $this->binder->writeCompiledFile('installed.json', 'binder.json');

            expect($test)->to->be->true();

        });

        it('should return false when the parser ->write() method return false', function () {

            $this->parser->shouldReceive('write')->once()
                ->with('binder.json', ['providers' => ['A', 'B']])
                ->andReturn(false);

            $test = $this->binder->writeCompiledFile('installed.json', 'binder.json');

            expect($test)->to->be->false();

        });

    });

});
