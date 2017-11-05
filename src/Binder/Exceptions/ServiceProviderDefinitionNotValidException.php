<?php declare(strict_types=1);

namespace Ellipse\Binder\Exceptions;

use UnexpectedValueException;

class ServiceProviderDefinitionNotValidException extends UnexpectedValueException implements BinderExceptionInterface
{
    public function __construct($definition)
    {
        $msg = "The service provider definition is not a valid:\n%s";

        parent::__construct(sprintf($msg, print_r($definition, true)));
    }
}
