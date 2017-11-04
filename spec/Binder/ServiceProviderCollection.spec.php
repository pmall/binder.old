<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\onStatic;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder\ManifestFile;
use Ellipse\Binder\ServiceProviderCollection;
use Ellipse\Binder\Exceptions\InvalidServiceProviderDefinitionException;

describe('ServiceProviderCollection', function () {

    beforeEach(function () {

        $this->manifest = mock(ManifestFile::class);

        $this->collection = new ServiceProviderCollection($this->manifest->get());

    });

    describe('->toArray()', function () {

        beforeEach(function () {

            $provider1 = onStatic(mock(ServiceProviderInterface::class));
            $provider2 = onStatic(mock(ServiceProviderInterface::class));

            $this->name1 = $provider1->className();
            $this->name2 = $provider2->className();

        });

        it('should return an array of service providers built from the manifest definitions', function () {

            $definitions = [
                [
                    'type' => ServiceProviderCollection::CLASS_TYPE,
                    'value' => $this->name1,
                ],
                [
                    'type' => ServiceProviderCollection::CLASS_TYPE,
                    'value' => $this->name2,
                ],
            ];

            $this->manifest->definitions->returns($definitions);

            $test = $this->collection->toArray();

            expect($test[0])->toBeAnInstanceOf($this->name1);
            expect($test[1])->toBeAnInstanceOf($this->name2);

        });

        it('should throw InvalidServiceProviderDefinitionException when one manifest definition is not valid', function () {

            $invalid = [
                'type' => 'wrong',
                'value' => $this->name1,
            ];

            $this->manifest->definitions->returns([$invalid]);

            $test = function () {

                $this->collection->toArray();

            };

            $exception = new InvalidServiceProviderDefinitionException($invalid);

            expect($test)->toThrow($exception);

        });

    });

});
