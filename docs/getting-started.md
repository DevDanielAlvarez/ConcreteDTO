# Getting Started

This guide shows how to install ConcreteDTO, define your first DTO, and create instances from different inputs.

You will:
- Install the package
- Declare a tiny DTO
- Import data from arrays, JSON, or any custom object

## Install

```bash
composer require alvarez/concrete-dto
```

ConcreteDTO requires PHP 8.1+ and works with any framework or plain PHP codebase.

## Define a DTO

Extend `AbstractDTO` and keep your constructor explicit. Public promoted properties are what ConcreteDTO will hydrate and export.

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
```

## Create instances

### From an array (fastest)

```php
$user = UserDTO::fromArray([
    'name' => 'Daniel Alvarez',
    'email' => 'alvarez@alvarez.com',
]);
```

### From JSON

```php
$json = '{"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}';
$user = UserDTO::fromJSON($json);
```

### From any type with a converter

Implement `DTOFrom` to describe how to turn a custom object into your DTO.

```php
<?php

use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\IsDTO;

final class UserRequest
{
    public function __construct(
        public readonly string $fullName,
        public readonly string $contact,
    ) {}
}

final class UserRequestToDTO implements DTOFrom
{
    public static function handle(mixed $dataToConvert): IsDTO
    {
        return new UserDTO(
            name: $dataToConvert->fullName,
            email: $dataToConvert->contact,
        );
    }
}

$request = new UserRequest('Daniel Alvarez', 'alvarez@alvarez.com');
$user = UserDTO::from(UserRequestToDTO::class, $request);
```

## Export and update quickly

Every DTO can be exported with `toArray()`, `toJson()`, or converted to another shape with `to(DTOTo::class)`. Use `cloneWith([...])` to keep immutability while changing selected fields.

### Export to array

```php
$data = $user->toArray();
// ['name' => 'Daniel Alvarez', 'email' => 'alvarez@alvarez.com']
```

### Export to JSON

```php
$json = $user->toJson();
// {"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}
```

### Update immutably

```php
$updated = $user->cloneWith(['email' => 'new@example.com']);
// Original $user remains unchanged
```

### Filter fields

```php
$publicData = $user->except(['email']);
// ['name' => 'Daniel Alvarez']
```

## Validation

Add custom validation by overriding the `validate()` method:

```php
final class UserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {}

    public static function validate(array $data): void
    {
        if (!filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }
    }
}
```

Validation runs automatically when using `fromArray()`, `fromJSON()`, or `cloneWith()`.

Next: dive into [Importing Data](/import) and [Exporting Data](/export).
