<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Binder\Factories\DefinitionFactoryInterface;
use Ellipse\Binder\Factories\SerializableDefinitionFactory;
use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\SerializableDefinition;

describe('SerializableDefinitionFactory', function () {

    beforeEach(function () {

        $this->delegate = mock(DefinitionFactoryInterface::class);

        $this->factory = new SerializableDefinitionFactory($this->delegate->get());

    });

    it('should implement DefinitionFactoryInterface', function () {

        expect($this->factory)->toBeAnInstanceOf(DefinitionFactoryInterface::class);

    });

    describe('->__invoke()', function () {

        it('should use the delegate to build a definition and return it wrapped in a SerializableDefinition', function () {

            $data = ['type' => 'other', 'key' => 'value'];

            $definition = mock(DefinitionInterface::class)->get();

            $this->delegate->__invoke->returns($definition);

            $test = ($this->factory)($data);

            expect($test)->toBeAnInstanceOf(SerializableDefinition::class);
            $this->delegate->__invoke->calledWith($data);

        });

    });

});
