# Importing Data

ConcreteDTO offers three entry points for building DTOs from external data. Each method keeps the constructor as the single source of truth, so property definitions stay explicit.

Use this page when you need to accept payloads from APIs, CLI args, or legacy objects without leaking framework models into your DTOs.

## `fromArray(array $data): static`

Hydrate directly from associative arrays that match your constructor signature. Validation hooks can be added by overriding `validate()` in your DTO.

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

$user = UserDTO::fromArray([
    'name' => 'Daniel Alvarez',
    'email' => 'alvarez@alvarez.com',
]);
```

## `fromJSON(string $json): static`

Parse JSON into the same predictable constructor call.

```php
$json = '{"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}';
$user = UserDTO::fromJSON($json);
```

If the JSON contains extra keys, only the ones that match your constructor parameters will be used.

> Tip: keep JSON field names aligned with your constructor parameter names to avoid silent drops.

## `from(DTOFrom|string $conversor, mixed $dataToConvert): static`

Translate any input type into your DTO by implementing `DTOFrom`. This keeps conversion logic close to the DTO definition.

```php
<?php

use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\IsDTO;
use Alvarez\ConcreteDto\AbstractDTO;

final class LegacyUser
{
    public function __construct(
        public readonly string $full_name,
        public readonly string $contact,
    ) {}
}

final class LegacyUserToDTO implements DTOFrom
{
    public static function handle(mixed $dataToConvert): IsDTO
    {
        $parts = explode(' ', $dataToConvert->full_name, 2);

        return new UserDTO(
            name: $parts[0],
            email: $dataToConvert->contact,
        );
    }
}

$legacy = new LegacyUser('Daniel Alvarez', 'alvarez@alvarez.com');
$user = UserDTO::from(LegacyUserToDTO::class, $legacy);
```

With these three methods you can accept arrays, JSON payloads, or domain objects without leaking framework models into your DTOs.

Next: see how to emit data with [Exporting Data](/export).
