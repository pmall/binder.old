<?php declare(strict_types=1);

namespace Ellipse\Binder\Definitions\Exceptions;

use UnexpectedValueException;

use Ellipse\Binder\Definitions\DefinitionInterface;

class DefinitionNotValidException extends UnexpectedValueException implements DefinitionExceptionInterface
{
    public function __construct(array $expected, array $data)
    {
        $type = $data[DefinitionInterface::TYPE_KEY];

        $msg = "The '%s' service provider definition type must have the keys [%s]:\n%s";

        parent::__construct(sprintf($msg, $type, implode(', ', $expected), print_r($data, true)));
    }
}
