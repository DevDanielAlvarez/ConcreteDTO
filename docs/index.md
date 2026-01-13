# ConcreteDTO

ConcreteDTO is a small, explicit PHP Data Transfer Object library that keeps data predictable and readable. Learn it in minutes, keep it in your toolbox for years.

## Why ConcreteDTO

- Tiny API focused on constructor-first DTOs
- Clear import/export helpers for arrays, JSON, and custom converters
- Immutability helpers to prevent sneaky mutations
- Framework-agnostic and dependency-light

## Quick example

```php
<?php

use Alvarez\ConcreteDto\AbstractDTO;

final class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {}
}

// Import from array
$user = UserDTO::fromArray([
    'name' => 'Daniel Alvarez',
    'email' => 'alvarez@alvarez.com',
]);

// Import from JSON
$user = UserDTO::fromJSON('{"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}');

// Export to array
$data = $user->toArray();
// ['name' => 'Daniel Alvarez', 'email' => 'alvarez@alvarez.com']

// Export to JSON
$json = $user->toJson();
// {"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}

// Immutability
$updated = $user->cloneWith(['email' => 'new@example.com']);

// Filter fields
$filtered = $user->except(['email']);
// ['name' => 'Daniel Alvarez']
```

## Core methods at a glance

- `fromArray()`, `fromJSON()`, `from(DTOFrom)` for inputs
- `toArray()`, `toJson()`, `to(DTOTo)` for outputs
- `cloneWith()` and `except()` for immutable workflows

## Quick export examples

```php
// HTTP response
return response()->json($user->toArray());

// Queue payload
dispatch(new SendEmailJob($user->toJson()));

// Export to domain model
use Alvarez\ConcreteDto\Contracts\DTOTo;
use Alvarez\ConcreteDto\Contracts\IsDTO;

final class UserDTOToModel implements DTOTo
{
    public static function handle(IsDTO $dto): mixed
    {
        return new UserModel(
            name: $dto->name,
            email: $dto->email,
        );
    }
}

$model = $user->to(UserDTOToModel::class);

// Filter sensitive data
$publicData = $user->except(['email']);
// ['name' => 'Daniel Alvarez']
```

Use the pages on the left for deeper guides and recipes.
