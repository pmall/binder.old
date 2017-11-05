<?php

use Ellipse\Binder\Exceptions\BinderExceptionInterface;
use Ellipse\Binder\Exceptions\ServiceProviderDefinitionNotValidException;

describe('ServiceProviderDefinitionNotValidException', function () {

    beforeEach(function () {

        $this->exception = new ServiceProviderDefinitionNotValidException([]);

    });

    it('should implement BinderExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(BinderExceptionInterface::class);

    });

});
