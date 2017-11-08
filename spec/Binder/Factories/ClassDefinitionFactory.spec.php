<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Binder\Factories\DefinitionFactoryInterface;
use Ellipse\Binder\Factories\ClassDefinitionFactory;
use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\ClassDefinition;

describe('ClassDefinitionFactory', function () {

    beforeEach(function () {

        $this->delegate = mock(DefinitionFactoryInterface::class);

        $this->factory = new ClassDefinitionFactory($this->delegate->get());

    });

    it('should implement DefinitionFactoryInterface', function () {

        expect($this->factory)->toBeAnInstanceOf(DefinitionFactoryInterface::class);

    });

    describe('->__invoke()', function () {

        context('when the definition type value is the class type', function () {

            it('should return a new ClassDefinition', function () {

                $data = [
                    'type' => ClassDefinition::TYPE,
                    'value' => 'App\\SomeClass',
                ];

                $test = ($this->factory)($data);

                expect($test)->toBeAnInstanceOf(ClassDefinition::class);

            });

        });

        context('when the definition type value is not the class type', function () {

            it('should proxy the delegate ->__invoke() method', function () {

                $data = ['type' => 'other', 'key' => 'value'];

                $definition = mock(DefinitionInterface::class)->get();

                $this->delegate->__invoke->returns($definition);

                $test = ($this->factory)($data);

                expect($test)->toBe($definition);
                $this->delegate->__invoke->calledWith($data);

            });

        });

    });

});
