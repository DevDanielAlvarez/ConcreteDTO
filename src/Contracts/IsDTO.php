<?php

namespace Alvarez\ConcreteDto\Contracts;

/**
 * Defines a class as DTO
 */
interface IsDTO
{
  // ====> Start Creation Methods <====
  /**
   * Create a DTO from an array
   * @param array $data
   * @return static
   */
  public static function fromArray(array $data): static;

  /**
   * Create a DTO from a JSON
   * @param string $json
   * @return static
   */
  public static function fromJson(string $json): static;


  /**
   * Create a DTO from a custom data type
   * @param DTOFrom $dataToConvert
   * @param mixed $dataToConvert
   * @return static
   */
  public static function from(DTOFrom $conversor, mixed $dataToConvert): static;

  // ====> End Creation Methods <====

  // ====> Start Export Methods <====

  /**
   * Convert the current DTO to an array
   * @return array
   */
  public function toArray(): array;

  /**
   * Convert the current to a JSON
   * @return string
   */
  public function toJson(): string;

  /**
   * Conver a custom data type in a DTO
   * @param DTOTo $conversor
   * @return mixed
   */
  public function to(DTOTo $conversor): mixed;
  // ===> End Export Methods <====

  /**
   * Useful for updating specific properties while maintaining immutability
   * @param array $values The values to be merged or updated in the new instance
   * @return static A new instance of the DTO with the updated values
   */
  public function cloneWith(array $fields): static;

  /**
   * Returns the DTO as an array, excluding specified keys.
   *
   * @param array $keys The property names to be excluded from the resulting array.
   * @return array The filtered array.
   */
  public function except(array $keys): array;

  /**
   * Validate data of DTO
   * @return void
   */
  public static function validate(array $data): void;
}
