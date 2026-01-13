<?php

namespace Alvarez\ConcreteDto\Contracts;

interface DTOTo
{
    public static function handle(IsDTO $dto): mixed;
}