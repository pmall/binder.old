<?php declare(strict_types=1);

namespace Ellipse\Binder\Exceptions;

use UnexpectedValueException;

class ClassDefinitionNotValidException extends UnexpectedValueException implements BinderExceptionInterface
{
    public function __construct(array $data)
    {
        $msg = "The service provider definition is not valid:\n%s";

        parent::__construct(sprintf($msg, print_r($data, true)));
    }
}
