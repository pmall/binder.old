<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinitionInterface;
use Ellipse\Binder\Definitions\ValidClassDefinition;
use Ellipse\Binder\Definitions\Exceptions\DefinitionNotValidException;

describe('ValidClassDefinition', function () {

    beforeEach(function () {

        $this->delegate = mock(ClassDefinitionInterface::class);

        $this->definition = new ValidClassDefinition($this->delegate->get());

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

        context('when the definition data is valid', function () {

            it('should proxy the delegate ->toServiceProvider() method', function () {

                $this->delegate->toArray->returns([
                    DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
                    ClassDefinitionInterface::CLASS_KEY => 'App\\SomeClass',
                ]);

                $provider = mock(ServiceProviderInterface::class)->get();

                $this->delegate->toServiceProvider->returns($provider);

                $test = $this->definition->toServiceProvider();

                expect($test)->toBe($provider);

            });

        });

        context('when the class definition data is not valid', function () {

            context('when the definition data does not have a value key', function () {

                it('should throw a DefinitionNotValidException', function () {

                    $data = [
                        DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
                        'key' => 'App\\SomeClass',
                    ];

                    $this->delegate->toArray->returns($data);

                    $test = function () {

                        $this->definition->toServiceProvider();

                    };

                    $expected = [
                        DefinitionInterface::TYPE_KEY,
                        ClassDefinitionInterface::CLASS_KEY,
                    ];

                    $exception = new DefinitionNotValidException($expected, $data);

                    expect($test)->toThrow($exception);

                });

            });

            context('when the definition data has less than two keys', function () {

                it('should throw a DefinitionNotValidException', function () {

                    $data = [
                        DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
                    ];

                    $this->delegate->toArray->returns($data);

                    $test = function () {

                        $this->definition->toServiceProvider();

                    };

                    $expected = [
                        DefinitionInterface::TYPE_KEY,
                        ClassDefinitionInterface::CLASS_KEY,
                    ];

                    $exception = new DefinitionNotValidException($expected, $data);

                    expect($test)->toThrow($exception);

                });

            });

            context('when the definition data has more than two keys', function () {

                it('should throw a DefinitionNotValidException', function () {

                    $data = [
                        DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
                        ClassDefinitionInterface::CLASS_KEY => 'App\\SomeClass',
                        'key' => 'value',
                    ];

                    $this->delegate->toArray->returns($data);

                    $test = function () {

                        $this->definition->toServiceProvider();

                    };

                    $expected = [
                        DefinitionInterface::TYPE_KEY,
                        ClassDefinitionInterface::CLASS_KEY,
                    ];

                    $exception = new DefinitionNotValidException($expected, $data);

                    expect($test)->toThrow($exception);

                });

            });

        });

    });

});
