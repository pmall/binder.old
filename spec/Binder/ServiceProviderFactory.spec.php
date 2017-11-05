<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ServiceProviderFactory;
use Ellipse\Binder\ServiceProviderFactoryInterface;
use Ellipse\Binder\Exceptions\ServiceProviderDefinitionNotValidException;

describe('ServiceProviderFactory', function () {

    beforeEach(function () {

        $this->delegate = mock(ServiceProviderFactoryInterface::class);

        $this->factory = new ServiceProviderFactory($this->delegate->get());

    });

    it('should implement ServiceProviderFactoryInterface', function () {

        expect($this->factory)->toBeAnInstanceOf(ServiceProviderFactoryInterface::class);

    });

    describe('::newInstance()', function () {

        it('should return a new ServiceProviderFactory', function () {

            $test = ServiceProviderFactory::newInstance();

            expect($test)->toBeAnInstanceOf(ServiceProviderFactoryInterface::class);

        });

    });

    describe('->__invoke()', function () {

        context('when the given definition is valid', function () {

            it('should proxy the delegate ->__invoke() method', function () {

                $definition = ['type' => 'class', 'value' => 'App\SomeClass'];

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->delegate->__invoke->returns($provider);

                $test = ($this->factory)($definition);

                expect($test)->toBe($provider);
                $this->delegate->__invoke->calledWith($definition);

            });

        });

        context('when the given definition is not valid', function () {

            beforeEach(function () {

                $this->getTest = function ($definition) {

                    return function () use ($definition) {

                        ($this->factory)($definition);

                    };

                };

            });

            context('when the given definition has more than two values', function () {

                it('should throw a ServiceProviderDefinitionNotValidException', function () {

                    $definition = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];

                    $test = ($this->getTest)($definition);

                    $exception = new ServiceProviderDefinitionNotValidException($definition);

                    expect($test)->toThrow($exception);

                });

            });

            context('when the given definition has no type key', function () {

                it('should throw a ServiceProviderDefinitionNotValidException', function () {

                    $definition = ['key' => 'value', 'value' => 'App\\SomeClass'];

                    $test = ($this->getTest)($definition);

                    $exception = new ServiceProviderDefinitionNotValidException($definition);

                    expect($test)->toThrow($exception);

                });

            });

            context('when the given definition has no value key', function () {

                it('should throw a ServiceProviderDefinitionNotValidException', function () {

                    $definition = ['type' => 'class', 'key' => 'value'];

                    $test = ($this->getTest)($definition);

                    $exception = new ServiceProviderDefinitionNotValidException($definition);

                    expect($test)->toThrow($exception);

                });

            });

        });

    });

});
