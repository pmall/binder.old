<?php

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\DefinitionWithUnknownType;
use Ellipse\Binder\Definitions\Exceptions\DefinitionTypeUnknownException;

describe('DefinitionWithUnknownType', function () {

    beforeEach(function () {

        $this->data = [
            DefinitionInterface::TYPE_KEY => 'unknown',
            'key' => 'value',
        ];

        $this->definition = new DefinitionWithUnknownType($this->data);

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

        it('should throw a DefinitionTypeUnknownException', function () {

            $test = function () {

                $this->definition->toServiceProvider();

            };

            $exception = new DefinitionTypeUnknownException($this->data);

            expect($test)->toThrow($exception);

        });

    });

});
