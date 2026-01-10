<?php

namespace Alvarez\ConcreteDto\Contracts;

interface DTOto
{
    public static function handle(IsDTO $dto): mixed;
}