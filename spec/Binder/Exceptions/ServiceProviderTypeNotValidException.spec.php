<?php

use Ellipse\Binder\Exceptions\BinderExceptionInterface;
use Ellipse\Binder\Exceptions\ServiceProviderTypeNotValidException;

describe('ServiceProviderTypeNotValidException', function () {

    beforeEach(function () {

        $this->exception = new ServiceProviderTypeNotValidException('type');

    });

    it('should implement BinderExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(BinderExceptionInterface::class);

    });

});
