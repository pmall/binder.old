<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions\Exceptions;

use UnexpectedValueException;

use Ellipse\Binder\Definitions\DefinitionInterface;

class DefinitionTypeUnknownException extends UnexpectedValueException implements DefinitionExceptionInterface
{
    public function __construct(array $data)
    {
        $type = $data[DefinitionInterface::TYPE_KEY];

        $msg = "The type '%s' is not a known service provider definition type.\n%s";

        parent::__construct(sprintf($msg, $type, print_r($data, true)));
    }
}
