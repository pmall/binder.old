<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\onStatic;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinition;
use Ellipse\Binder\Exceptions\ClassDefinitionNotValidException;
use Ellipse\Binder\Exceptions\ServiceProviderClassNotFoundException;

describe('ClassDefinition', function () {

    beforeEach(function () {

        $this->class = onStatic(mock(ServiceProviderInterface::class))->className();

        $this->data = [
            'type' => ClassDefinition::TYPE,
            'value' => $this->class,
        ];

        $this->definition = new ClassDefinition($this->data);

    });

    it('should implement DefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(DefinitionInterface::class);

    });

    describe('->toArray()', function () {

        it('should return the definition array', function () {

            $test = $this->definition->toArray();

            expect($test)->toEqual($this->data);

        });

    });

    describe('->toServiceProvider()', function () {

        context('when the definition is valid and the value key value is an existing class name', function () {

            it('should return an instance of the defined class name', function () {

                $test = $this->definition->toServiceProvider();

                expect($test)->toBeAnInstanceOf($this->class);

            });

        });

        context('when the definition does not have exactly two values', function () {

            it('should throw a ClassDefinitionNotValidException', function () {

                $data = [
                    'type' => ClassDefinition::TYPE,
                    'value' => 'App\\SomeClass',
                    'key' => 'value',
                ];

                $definition = new ClassDefinition($data);

                $test = function () use ($definition) {

                    $definition->toServiceProvider();

                };

                $exception = new ClassDefinitionNotValidException($data);

                expect($test)->toThrow($exception);

            });

        });

        context('when the definition does not have a value key', function () {

            it('should throw a ClassDefinitionNotValidException', function () {

                $data = [
                    'type' => ClassDefinition::TYPE,
                ];

                $definition = new ClassDefinition($data);

                $test = function () use ($definition) {

                    $definition->toServiceProvider();

                };

                $exception = new ClassDefinitionNotValidException($data);

                expect($test)->toThrow($exception);

            });

        });

        context('when the value is not an existing class', function () {

            it('should throw a ServiceProviderClassNotFoundException', function () {

                $definition = new ClassDefinition([
                    'type' => ClassDefinition::TYPE,
                    'value' => 'notfound',
                ]);

                $test = function () use ($definition) {

                    $definition->toServiceProvider();

                };

                $exception = new ServiceProviderClassNotFoundException('notfound');

                expect($test)->toThrow($exception);

            });

        });

    });

});
