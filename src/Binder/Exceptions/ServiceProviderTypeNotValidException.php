<?php declare(strict_types=1);

namespace Ellipse\Binder\Exceptions;

use UnexpectedValueException;

class ServiceProviderTypeNotValidException extends UnexpectedValueException implements BinderExceptionInterface
{
    public function __construct(string $type)
    {
        $msg = 'The service provider definition type is not valid: \'%s\'.';

        parent::__construct(sprintf($msg, $type));
    }
}
