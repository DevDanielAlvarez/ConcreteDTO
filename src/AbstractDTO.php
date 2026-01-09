<?php

namespace Alvarez\ConcreteDto;

use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\IsDTO;

abstract class AbstractDTO implements IsDTO
{
    // ====> Start Creation Methods <====
    /**
     * Create a DTO from an array
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        // return the children class with the converted data from array
        return new static(...$data);
    }

    /**
     * Create a DTO from a JSON
     * @param string $json
     * @return static
     */
    public static function fromJSON(string $json): static
    {
        // return the children class with the converted data from json
        return new static(...json_decode(json: $json, associative: true));
    }

    /**
     * Create a DTO from a custom data type
     * @param DTOFrom $dataToConvert
     * @return static
     */
    public static function from(DTOFrom $conversor, mixed $dataToConvert): static
    {
        // use handle method to convert data in a DTO
        return $conversor->handle($dataToConvert);
    }

}