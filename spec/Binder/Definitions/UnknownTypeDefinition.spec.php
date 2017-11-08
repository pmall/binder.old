<?php

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\UnknownTypeDefinition;
use Ellipse\Binder\Exceptions\DefinitionTypeMissingException;
use Ellipse\Binder\Exceptions\DefinitionTypeNotValidException;

describe('UnknownTypeDefinition', function () {

    beforeEach(function () {

        $this->data = [
            'type' => 'unknown',
            'key' => 'value',
        ];

        $this->definition = new UnknownTypeDefinition($this->data);

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

        context('when the type key is missing', function () {

            it('should throw a DefinitionTypeMissingException', function () {

                $data = ['key' => 'value'];

                $definition = new UnknownTypeDefinition($data);

                $test = function () use ($definition) {

                    $definition->toServiceProvider();

                };

                $exception = new DefinitionTypeMissingException($data);

                expect($test)->toThrow($exception);

            });

        });

        context('when the type key is present', function () {

            it('should throw a DefinitionTypeNotValidException', function () {

                $data = ['type' => 'unknown', 'key' => 'value'];

                $definition = new UnknownTypeDefinition($data);

                $test = function () use ($definition) {

                    $definition->toServiceProvider();

                };

                $exception = new DefinitionTypeNotValidException('unknown');

                expect($test)->toThrow($exception);

            });

        });

    });

});
