<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Binder\JsonFile;
use Ellipse\Binder\InstalledPackageFile;
use Ellipse\Binder\DefinitionFileInterface;
use Ellipse\Binder\ServiceProviderCollection;

describe('InstalledPackageFile', function () {

    beforeEach(function () {

        $this->json = mock(JsonFile::class);

        $this->installed = new InstalledPackageFile($this->json->get());

    });

    it('should implement DefinitionFileInterface', function () {

        expect($this->installed)->toBeAnInstanceOf(DefinitionFileInterface::class);

    });

    describe('->definitions()', function () {

        it('should return the service provider definitions contained in the file', function () {

            $definitions1 = [
                [
                    'type' => ServiceProviderCollection::CLASS_TYPE,
                    'value' => 'App\\SomeClass',
                ],
            ];

            $definitions2 = [
                [
                    'type' => ServiceProviderCollection::CLASS_TYPE,
                    'value' => 'App\\SomeOtherClass',
                ],
            ];

            $data = [
                [],
                [
                    'extra' => [
                        DefinitionFileInterface::BINDINGS_KEY => $definitions1,
                    ],
                ],
                [
                    'extra' => [
                        DefinitionFileInterface::BINDINGS_KEY => $definitions2,
                    ],
                ],
            ];

            $this->json->read->returns($data);

            $test = $this->installed->definitions();

            expect($test)->toEqual(array_merge($definitions1, $definitions2));

        });

    });

});
