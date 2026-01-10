<?php

use Alvarez\ConcreteDto\AbstractDTO;
use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\IsDTO;

class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name
    ) {
    }
}

it('can create a DTO from an array', function () {
    $userDTO = UserDTO::fromArray(['name' => 'Daniel Alvarez']);
    expect($userDTO->name)->toBe('Daniel Alvarez');
});

it('can create from json', function () {
    $userDTO = UserDTO::fromJSON('{"name": "Daniel Alvarez"}');
    expect($userDTO->name)->toBe('Daniel Alvarez');
});

it('can from any type', function () {

    class AnotherDTO
    {
        public function __construct(
            public readonly string $fullName = 'Dnaiel Alvarez'
        ) {
        }
    }
    class ConvertAnotherDTOInUserDTO implements DTOFrom
    {
        public static function handle(mixed $dataToConvert): IsDTO
        {
            $lastName = ltrim(strrchr($dataToConvert->fullName, ' '));
            return new UserDTO(name: $lastName);
        }
    }
    $anotherDTO = new AnotherDTO(fullName: 'Daniel Alvarez');
    $userDTO = UserDTO::from(conversor: new ConvertAnotherDTOInUserDTO(), dataToConvert: $anotherDTO);
    expect($userDTO->name)->toBe('Alvarez');
});