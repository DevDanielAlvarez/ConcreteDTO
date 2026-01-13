<?php

use Alvarez\ConcreteDto\AbstractDTO;
use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\IsDTO;
use PharIo\Manifest\Email;

class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public null|string $email = null
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
            $firstName = explode(' ', $dataToConvert->fullName)[0];
            return new UserDTO(name: $firstName);
        }
    }
    $anotherDTO = new AnotherDTO(fullName: 'Daniel Alvarez');
    $userDTO = UserDTO::from(conversor: new ConvertAnotherDTOInUserDTO(), dataToConvert: $anotherDTO);
    expect($userDTO->name)->toBe('Daniel');
});

it('can clone with different data', function () {

    $userDTO = new UserDTO(name: 'Daniel Alvarez', email: 'alvarez@alvarez.com');

    $newDTO = $userDTO->cloneWith(['email' => 'alva@alva.com']);

    expect($newDTO)->toBeInstanceOf(UserDTO::class);

    expect($newDTO->name)->toBe('Daniel Alvarez');
    expect($newDTO->email)->toBe('alva@alva.com');

});