<?php

use Ellipse\Binder\Exceptions\BinderExceptionInterface;
use Ellipse\Binder\Exceptions\DefinitionTypeMissingException;

describe('DefinitionTypeMissingException', function () {

    beforeEach(function () {

        $this->exception = new DefinitionTypeMissingException([]);

    });

    it('should implement BinderExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(BinderExceptionInterface::class);

    });

});
