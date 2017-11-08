<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Binder\DefinitionFactory;
use Ellipse\Binder\Factories\DefinitionFactoryInterface;
use Ellipse\Binder\Definitions\DefinitionInterface;

describe('DefinitionFactory', function () {

    beforeEach(function () {

        $this->delegate = mock(DefinitionFactoryInterface::class);

        $this->factory = new DefinitionFactory($this->delegate->get());

    });

    it('should implement DefinitionFactoryInterface', function () {

        expect($this->factory)->toBeAnInstanceOf(DefinitionFactoryInterface::class);

    });

    describe('::newInstance()', function () {

        it('should return a new DefinitionFactory', function () {

            $test = DefinitionFactory::newInstance();

            expect($test)->toBeAnInstanceOf(DefinitionFactory::class);

        });

    });

    describe('__invoke()', function () {

        it('should proxy the delegate ->__invoke() method', function () {

            $definition = mock(DefinitionInterface::class)->get();

            $this->delegate->__invoke->returns($definition);

            $test = ($this->factory)(['key' => 'value']);

            expect($test)->toBe($definition);
            $this->delegate->__invoke->calledWith(['key' => 'value']);

        });

    });

});
