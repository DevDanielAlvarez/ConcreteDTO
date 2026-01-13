# ConcreteDTO

ConcreteDTO is a small, explicit PHP Data Transfer Object library for keeping data structures predictable and well-defined. It favors readable constructors, clear conversion methods, and a lightweight surface area you can learn in minutes.

## Quick example

```php
<?php

use Alvarez\ConcreteDto\AbstractDTO;
use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\DTOTo;
use Alvarez\ConcreteDto\Contracts\IsDTO;

final class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $birthday = null,
    ) {}
}

final class UserModel
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {}
}

final class UserModelToDTO implements DTOFrom
{
    public static function handle(mixed $dataToConvert): IsDTO
    {
        return new UserDTO(name: $dataToConvert->name, email: $dataToConvert->email);
    }
}

final class UserDTOToModel implements DTOTo
{
    public static function handle(IsDTO $dto): mixed
    {
        return new UserModel(name: $dto->name, email: $dto->email);
    }
}

$user = UserDTO::fromArray([
    'name' => 'Daniel Alvarez',
    'email' => 'alvarez@alvarez.com',
]);

$userFromJson = UserDTO::fromJSON('{"name": "Daniel Alvarez", "email": "alvarez@alvarez.com"}');

$userFromModel = UserDTO::from(UserModelToDTO::class, new UserModel('Daniel', 'daniel@example.com'));

$asArray = $user->toArray();
$asJson = $user->toJson();
$asModel = $user->to(UserDTOToModel::class);

$updated = $user->cloneWith(['email' => 'new@example.com']);
```

Head to the sections on the left to see each capability in detail.
