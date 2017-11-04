<?php

use Ellipse\Binder\Exceptions\BinderExceptionInterface;
use Ellipse\Binder\Exceptions\InvalidServiceProviderDefinitionException;

describe('InvalidServiceProviderDefinitionException', function () {

    beforeEach(function () {

        $this->exception = new InvalidServiceProviderDefinitionException([]);

    });

    it('should implement BinderExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(BinderExceptionInterface::class);

    });

});
