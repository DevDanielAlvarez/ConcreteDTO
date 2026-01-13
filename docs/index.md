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

// Import
$user = UserDTO::fromArray([
    'name' => 'Daniel Alvarez',
    'email' => 'alvarez@alvarez.com',
]);

// Export
$payload = $user->toJson();

// Immutability
$updated = $user->cloneWith(['email' => 'new@example.com']);
```

## Core methods at a glance

- `fromArray()`, `fromJSON()`, `from(DTOFrom)` for inputs
- `toArray()`, `toJson()`, `to(DTOTo)` for outputs
- `cloneWith()` and `except()` for immutable workflows

Use the pages on the left for deeper guides and recipes.
