<?php

require __DIR__ . '/../../Fixtures/definition.php';

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\onStatic;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ServiceProviderFactoryInterface;
use Ellipse\Binder\Factories\AbstractServiceProviderFactory;
use Ellipse\Binder\Factories\ClassServiceProviderFactory;
use Ellipse\Binder\Exceptions\ServiceProviderClassNotFoundException;

describe('ClassServiceProviderFactory', function () {

    beforeEach(function () {

        $this->delegate = mock(ServiceProviderFactoryInterface::class);

        $this->factory = new ClassServiceProviderFactory($this->delegate->get());

    });

    it('should extend AbstractServiceProviderFactory', function () {

        expect($this->factory)->toBeAnInstanceOf(AbstractServiceProviderFactory::class);

    });

    describe('->canHandle()', function () {

        context('when the given type is self::TYPE_CLASS', function () {

            it('should return true', function () {

                $test = $this->factory->canHandle(ClassServiceProviderFactory::TYPE_CLASS);

                expect($test)->toBeTruthy();

            });

        });

        context('when the given type is not self::TYPE_CLASS', function () {

            it('should return false', function () {

                $test = $this->factory->canHandle('something');

                expect($test)->toBeFalsy();

            });

        });

    });

    describe('->createServiceProvider()', function () {

        context('when the given value is the name of an existing class', function () {

            it('should return an instance of the class', function () {

                $class = onStatic(mock(ServiceProviderInterface::class));

                $value = $class->className();

                $test = $this->factory->createServiceProvider($value);

                expect($test)->toBeAnInstanceOf(ServiceProviderInterface::class);

            });

        });

        context('when the given value is not the name of an existing class', function () {

            it('should throw a ServiceProviderClassNotFoundException', function () {

                $test = function () {

                    $this->factory->createServiceProvider('App\\SomeClass');

                };

                $exception = new ServiceProviderClassNotFoundException('App\\SomeClass');

                expect($test)->toThrow($exception);

            });

        });

    });

    describe('->delegate()', function () {

        it('should proxy the delegate ->__invoke() method', function () {

            $definition = definition('App\SomeClass');

            $provider = mock(ServiceProviderInterface::class)->get();

            $this->delegate->__invoke->returns($provider);

            $test = $this->factory->delegate($definition);

            expect($test)->toBe($provider);
            $this->delegate->__invoke->calledWith($definition);

        });

    });

});
