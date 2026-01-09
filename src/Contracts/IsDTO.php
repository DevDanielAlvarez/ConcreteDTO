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
   * @param DTOto $conversor
   * @return mixed
   */
  public function to(DTOto $conversor): mixed;
  // ===> End Export Methods <====

}
