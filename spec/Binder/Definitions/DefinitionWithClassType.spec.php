<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinitionInterface;
use Ellipse\Binder\Definitions\DefinitionWithClassType;

describe('DefinitionWithClassType', function () {

    beforeEach(function () {

        $this->delegate = mock(ClassDefinitionInterface::class);
        $this->fallback = mock(DefinitionInterface::class);

        $this->definition = new DefinitionWithClassType($this->delegate->get(), $this->fallback->get());

    });

    it('should implement DefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(DefinitionInterface::class);

    });

    it('should implement ClassDefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(ClassDefinitionInterface::class);

    });

    describe('::newInstance()', function () {

        it('should return a new DefinitionWithClassType', function () {

            $test = DefinitionWithClassType::newInstance([], $this->fallback->get());

            expect($test)->toBeAnInstanceOf(DefinitionWithClassType::class);

        });

    });

    context('when the definition type key is the class type key', function () {

        beforeEach(function () {

            $this->data = [
                DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
            ];

            $this->delegate->toArray->returns($this->data);

        });

        describe('->toArray()', function () {

            it('should proxy the delegate ->toArray() method', function () {

                $test = $this->definition->toArray();

                expect($test)->toEqual($this->data);

            });

        });

        describe('->toServiceProvider()', function () {

            it('should proxy the delegate ->toServiceProvider() method', function () {

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->delegate->toServiceProvider->returns($provider);

                $test = $this->definition->toServiceProvider();

                expect($test)->toBe($provider);

            });

        });

    });

    context('when the definition type key is the not the class type key', function () {

        beforeEach(function () {

            $this->data = [
                DefinitionInterface::TYPE_KEY => 'value',
            ];

            $this->delegate->toArray->returns([
                DefinitionInterface::TYPE_KEY => 'notclass',
            ]);

            $this->fallback->toArray->returns($this->data);

        });

        describe('->toArray()', function () {

            it('should proxy the fallback ->toArray() method', function () {

                $test = $this->definition->toArray();

                expect($test)->toEqual($this->data);

            });

        });

        describe('->toServiceProvider()', function () {

            it('should proxy the fallback ->toServiceProvider() method', function () {

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->fallback->toServiceProvider->returns($provider);

                $test = $this->definition->toServiceProvider();

                expect($test)->toBe($provider);

            });

        });

    });

});
