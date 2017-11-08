<?php

use Ellipse\Binder\Factories\DefinitionFactoryInterface;
use Ellipse\Binder\Factories\UnknownTypeDefinitionFactory;
use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\UnknownTypeDefinition;

describe('UnknownTypeDefinitionFactory', function () {

    beforeEach(function () {

        $this->factory = new UnknownTypeDefinitionFactory;

    });

    it('should implement DefinitionFactoryInterface', function () {

        expect($this->factory)->toBeAnInstanceOf(DefinitionFactoryInterface::class);

    });

    describe('->__invoke()', function () {

        it('should return a new UnknownTypeDefinition', function () {

            $test = ($this->factory)(['key' => 'value']);

            expect($test)->toBeAnInstanceOf(UnknownTypeDefinition::class);

        });

    });

});
