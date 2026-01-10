<?php

namespace Alvarez\ConcreteDto\Contracts;

/**
 * Interface to declare a DTO creator
 */
interface DTOFrom
{
    /**
     * Create a DTO from a custom data type
     * @param mixed $dataToConvert
     * @return void
     */
    public static function handle(mixed $dataToConvert): IsDTO;
}