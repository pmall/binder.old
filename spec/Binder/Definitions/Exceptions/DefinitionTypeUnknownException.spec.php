<?php

use Ellipse\Binder\Definitions\Exceptions\DefinitionExceptionInterface;
use Ellipse\Binder\Definitions\Exceptions\DefinitionTypeUnknownException;

describe('DefinitionTypeUnknownException', function () {

    beforeEach(function () {

        $this->exception = new DefinitionTypeUnknownException(['type' => 'value']);

    });

    it('should implement DefinitionExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(DefinitionExceptionInterface::class);

    });

});
