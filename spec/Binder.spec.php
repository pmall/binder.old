<?php

use function Eloquent\Phony\Kahlan\mock;

use Interop\Container\ServiceProviderInterface;

use Ellipse\Binder;
use Ellipse\Binder\Project;
use Ellipse\Binder\ServiceProviderCollection;

describe('Binder', function () {

    beforeEach(function () {

        $this->project = mock(Project::class);

        $this->binder = new Binder($this->project->get());

    });

    describe('::newInstance()', function () {

        it('should return a Binder instance', function () {

            $test = Binder::newInstance(sys_get_temp_dir());

            expect($test)->toBeAnInstanceOf(Binder::class);

        });

    });

    describe('->providers()', function () {

        it('should return an array of service provider instances built from the project manifest file definitions', function () {

            $providers = [
                mock(ServiceProviderInterface::class)->get(),
            ];

            $collection = mock(ServiceProviderCollection::class);

            $collection->toArray->returns($providers);

            allow(ServiceProviderCollection::class)->toBe($collection->get());

            $test = $this->binder->providers();

            expect($test)->toEqual($providers);
            $this->project->manifest->called();

        });

    });

});
