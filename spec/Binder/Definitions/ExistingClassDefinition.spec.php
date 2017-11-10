<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\onStatic;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinitionInterface;
use Ellipse\Binder\Definitions\ExistingClassDefinition;
use Ellipse\Binder\Definitions\Exceptions\ServiceProviderClassNotFoundException;

describe('ExistingClassDefinition', function () {

    beforeEach(function () {

        $this->delegate = mock(ClassDefinitionInterface::class);

        $this->definition = new ExistingClassDefinition($this->delegate->get());

    });

    it('should implement DefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(DefinitionInterface::class);

    });

    it('should implement ClassDefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(ClassDefinitionInterface::class);

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

        context('when the class defined by the delegate exists', function () {

            it('should proxy the delegate ->toServiceProvider() method', function () {

                $class = onStatic(mock(ServiceProviderInterface::class))->className();

                $this->delegate->toArray->returns([
                    DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
                    ClassDefinitionInterface::CLASS_KEY => $class,
                ]);

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->delegate->toServiceProvider->returns($provider);

                $test = $this->definition->toServiceProvider();

                expect($test)->toBe($provider);

            });

        });

        context('when the class defined by the delegate does not exist', function () {

            it('should throw a ServiceProviderClassNotFoundException', function () {

                $class = 'App\\SomeClass';

                $this->delegate->toArray->returns([
                    DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
                    ClassDefinitionInterface::CLASS_KEY => $class,
                ]);

                $test = function () {

                    $this->definition->toServiceProvider();

                };

                $exception = new ServiceProviderClassNotFoundException($class);

                expect($test)->toThrow($exception);

            });

        });

    });

});
