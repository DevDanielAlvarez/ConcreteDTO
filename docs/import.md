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

## Custom validation

Override the static `validate()` method to add custom validation logic. The method receives an array of data and should throw exceptions when validation fails.

### When validation runs

- **Automatically:** When using `fromArray()`, `fromJSON()`, or `cloneWith()`
- **Manual:** Call `self::validate($this->toArray())` in your constructor for validation on direct instantiation

```php
<?php

final class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {
        self::validate($this->toArray()); // Enables validation on `new UserDTO(...)`
    }

    public static function validate(array $data): void
    {
        if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }
        
        if (strlen($data['name'] ?? '') < 2) {
            throw new InvalidArgumentException('Name too short');
        }
    }
}

// Validation runs on import methods
$user = UserDTO::fromArray([
    'name' => 'Daniel Alvarez',
    'email' => 'alvarez@alvarez.com',
]); // ✓ Valid

$user = UserDTO::fromJSON('{"name":"A","email":"invalid"}');
// ✗ Throws InvalidArgumentException

// Also runs on direct instantiation (because of constructor call)
$user = new UserDTO('A', 'invalid');
// ✗ Throws InvalidArgumentException
```

### Validation best practices

- Keep validation logic simple and focused on data integrity
- Throw descriptive exceptions with clear error messages
- Use the `validate()` method for data structure validation, not business logic
- Call `self::validate($this->toArray())` in constructor only if you need validation on direct instantiation

With these three methods you can accept arrays, JSON payloads, or domain objects without leaking framework models into your DTOs.

Next: see how to emit data with [Exporting Data](/export).
