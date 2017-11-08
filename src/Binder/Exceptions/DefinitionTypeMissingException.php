<?php declare(strict_types=1);

namespace Ellipse\Binder\Exceptions;

use UnexpectedValueException;

class DefinitionTypeMissingException extends UnexpectedValueException implements BinderExceptionInterface
{
    public function __construct(array $data)
    {
        $msg = "The service provider definition type is missing:\n%s";

        parent::__construct(sprintf($msg, print_r($data, true)));
    }
}
