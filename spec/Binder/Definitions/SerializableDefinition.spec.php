<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\Definitions\DefinitionInterface;
use Ellipse\Binder\Definitions\SerializableDefinition;

describe('SerializableDefinition', function () {

    beforeEach(function () {

        $this->delegate = mock(DefinitionInterface::class);

        $this->definition = new SerializableDefinition($this->delegate->get());

    });

    it('should implement DefinitionInterface', function () {

        expect($this->definition)->toBeAnInstanceOf(DefinitionInterface::class);

    });

    it('should implement JsonSerializable', function () {

        expect($this->definition)->toBeAnInstanceOf(JsonSerializable::class);

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

        it('should proxy the delegate ->toServiceProvider() method', function () {

            $provider = mock(ServiceProviderInterface::class)->get();

            $this->delegate->toServiceProvider->returns($provider);

            $test = $this->definition->toServiceProvider();

            expect($test)->toBe($provider);

        });

    });

    describe('->jsonSerialize()', function () {

        it('should proxy the delegate ->toArray() method', function () {

            $data = ['key' => 'value'];

            $this->delegate->toArray->returns($data);

            $test = $this->definition->jsonSerialize();

            expect($test)->toEqual($data);

        });

    });

});
