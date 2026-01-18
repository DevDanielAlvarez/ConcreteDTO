# Exporting Data

ConcreteDTO makes it easy to move DTO data into formats your application expects. Keep export logic explicit and testable by using the helpers below.

Reach for these methods when you need HTTP responses, logs, queue payloads, or mapping into domain models.

## `toArray(): array`

Returns a flat associative array based on the DTO constructor properties.

```php
<?php

$userDTO = new UserDTO(
    name: 'Daniel Alvarez',
    email: 'alvarez@alvarez.com',
);

$array = $userDTO->toArray();
// ['name' => 'Daniel Alvarez', 'email' => 'alvarez@alvarez.com']
```

## `toJson(): string`

Serializes the DTO to JSON. Useful for HTTP responses or logging.

```php
$json = $userDTO->toJson();
// {"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}
```

## `to(DTOTo|string $conversor): mixed`

Convert the DTO into any custom structure by implementing `DTOTo`. This keeps mapping logic reusable and decoupled from controllers.

```php
<?php

use Alvarez\ConcreteDto\Contracts\DTOTo;
use Alvarez\ConcreteDto\Contracts\IsDTO;

final class UserDTOToModel implements DTOTo
{
    public static function handle(IsDTO $dto): mixed
    {
        return new UserModel(name: $dto->name, email: $dto->email);
    }
}

$userDTO = new UserDTO(name: 'Daniel Alvarez', email: 'alvarez@alvarez.com');
$model = $userDTO->to(UserDTOToModel::class);
```

By centralizing export rules, you avoid duplicated array casts scattered across the codebase and keep changes localized to your DTOs.

Next: keep your data flows predictable with [Immutability](/immutability).
