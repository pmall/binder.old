<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definition;
use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\Exceptions\DefinitionTypeMissingException;

describe('Definition', function () {

    beforeEach(function () {

        $this->delegate = mock(DefinitionInterface::class);

        $this->definition = new Definition($this->delegate->get());

    });

    it('should implement DefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(DefinitionInterface::class);

    });

    it('should implement JsonSerializable', function () {

        expect($this->definition)->toBeAnInstanceOf(JsonSerializable::class);

    });

    describe('::newInstance()', function () {

        it('should return a new Definition', function () {

            $test = Definition::newInstance(['key' => 'value']);

            expect($test)->toBeAnInstanceOf(Definition::class);

        });

    });

    describe('->toArray()', function () {

        it('should proxy the delegate ->toArray() method', function () {

            $data = ['key' => 'value'];

            $this->delegate->toArray->returns($data);

            $test = $this->definition->toArray();

            expect($test)->toEqual($data);

        });

    });

    describe('->toServiceProvider()', function () {

        context('when the definition data has a type key', function () {

            it('should proxy the delegate ->toServiceProvider() method', function () {

                $this->delegate->toArray->returns([DefinitionInterface::TYPE_KEY => 'value']);

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->delegate->toServiceProvider->returns($provider);

                $test = $this->definition->toServiceProvider();

                expect($test)->toBe($provider);

            });

        });

        context('when the definition data does not have a type key', function () {

            it('should throw a DefinitionTypeMissingException', function () {

                $data = ['key' => 'value'];

                $this->delegate->toArray->returns($data);

                $test = function () {

                    $this->definition->toServiceProvider();

                };

                $exception = new DefinitionTypeMissingException($data);

                expect($test)->toThrow($exception);

            });

        });

    });

    describe('->jsonSerialize()', function () {

        it('should proxy the delegate ->toArray() method', function () {

            $data = ['key' => 'value'];

            $this->delegate->toArray->returns($data);

            $test = $this->definition->jsonSerialize();

            expect($test)->toEqual($data);

        });

    });

});
