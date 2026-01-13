<?php

namespace Alvarez\ConcreteDto;

use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\DTOTo;
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
        self::validate($data);
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
        self::validate(json_decode($json, associative: true));
        // return the children class with the converted data from json
        return new static(...json_decode(json: $json, associative: true));
    }

    /**
     * Create a DTO from a custom data type
     * @param DTOFrom|string $conversor pass the new Conversor() or Conversor::class
     * @param mixed $dataToConvert
     * @return static
     */
    public static function from(DTOFrom|string $conversor, mixed $dataToConvert): static
    {
        // use handle method to convert data in a DTO
        return $conversor::handle($dataToConvert);
    }

    // ====> End Creation Methods <====

    // ====> Start Export Methods <====

    /**
     * Convert the current DTO to an array
     * @return array
     */
    public function toArray(): array
    {
        // return the children properties as array
        return get_object_vars($this);
    }

    /**
     * Convert the current to a JSON
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Conver a custom data type in a DTO
     * @param DTOTo $conversor
     * @return mixed
     */
    public function to(DTOTo|string $conversor): mixed
    {
        return $conversor::handle(dto: $this);
    }

    // ===> End Export Methods <====

    /**
     * Useful for updating specific properties while maintaining immutability
     * @param array $values The values to be merged or updated in the new instance
     * @return static A new instance of the DTO with the updated values
     */
    public function cloneWith(array $fields): static
    {
        return static::fromArray(array_merge($this->toArray(), $fields));
    }

    /**
     * Returns the DTO as an array, excluding specified keys.
     *
     * @param array $keys The property names to be excluded from the resulting array.
     * @return array The filtered array.
     */
    public function except(array $keys): array
    {
        return array_diff_key($this->toArray(), array_flip($keys));
    }

    /**
     * Validate data of DTO
     * @return void
     */
    public static function validate(array $data): void
    {

    }

}