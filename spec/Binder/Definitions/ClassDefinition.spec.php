<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\onStatic;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinition;

describe('ClassDefinition', function () {

    beforeEach(function () {

        $this->class = onStatic(mock(ServiceProviderInterface::class))->className();

        $this->data = [
            DefinitionInterface::TYPE_KEY => ClassDefinitionInterface::TYPE_VALUE,
            ClassDefinitionInterface::CLASS_KEY => $this->class,
        ];

        $this->definition = new ClassDefinition($this->data);

    });

    it('should implement DefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(DefinitionInterface::class);

    });

    it('should implement ClassDefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(ClassDefinitionInterface::class);

    });

    describe('->toArray()', function () {

        it('should return the definition array', function () {

            $test = $this->definition->toArray();

            expect($test)->toEqual($this->data);

        });

    });

    describe('->toServiceProvider()', function () {

        it('should return an instance of the defined class name', function () {

            $test = $this->definition->toServiceProvider();

            expect($test)->toBeAnInstanceOf($this->class);

        });

    });

});
