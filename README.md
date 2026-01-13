<div align="center">

<img src="assets/logo.png" alt="ConcreteDTO Logo" width="120" height="160">

# ConcreteDTO

A small, explicit PHP Data Transfer Object library that keeps data predictable and readable.

Learn it in minutes, keep it in your toolbox for years.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net/)

[Documentation](#documentation) • [Installation](#installation) • [Quick Start](#quick-start) • [API Reference](#api-reference)

</div>

---

## Why ConcreteDTO?

- **Tiny API** focused on constructor-first DTOs
- **Clear import/export helpers** for arrays, JSON, and custom converters
- **Immutability helpers** to prevent sneaky mutations
- **Framework-agnostic** and dependency-light

## Installation

```bash
composer require alvarez/concrete-dto
```

ConcreteDTO requires PHP 8.1+ and works with any framework or plain PHP codebase.

## Quick Start

### Define a DTO

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

### Import data

```php
// From array
$user = UserDTO::fromArray([
    'name' => 'Daniel Alvarez',
    'email' => 'alvarez@alvarez.com',
]);

// From JSON
$user = UserDTO::fromJSON('{"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}');

// From custom object
use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\IsDTO;

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

### Export data

```php
// To array
$data = $user->toArray();
// ['name' => 'Daniel Alvarez', 'email' => 'alvarez@alvarez.com']

// To JSON
$json = $user->toJson();
// {"name":"Daniel Alvarez","email":"alvarez@alvarez.com"}

// To custom object
use Alvarez\ConcreteDto\Contracts\DTOTo;

final class UserDTOToModel implements DTOTo
{
    public static function handle(IsDTO $dto): mixed
    {
        return new UserModel(name: $dto->name, email: $dto->email);
    }
}

$model = $user->to(UserDTOToModel::class);

// Filter fields
$publicData = $user->except(['email']);
// ['name' => 'Daniel Alvarez']
```

### Immutability

```php
// Clone with updates
$updated = $user->cloneWith(['email' => 'new@example.com']);
// Original $user remains unchanged
```

## API Reference

### Importing Methods

| Method | Purpose |
|--------|---------|
| `fromArray(array $data): static` | Create DTO from associative array |
| `fromJSON(string $json): static` | Create DTO from JSON string |
| `from(DTOFrom\|string $conversor, mixed $data): static` | Create DTO using custom converter |

### Exporting Methods

| Method | Purpose |
|--------|---------|
| `toArray(): array` | Export DTO as associative array |
| `toJson(): string` | Export DTO as JSON string |
| `to(DTOTo\|string $conversor): mixed` | Export DTO using custom converter |

### Immutability Methods

| Method | Purpose |
|--------|---------|
| `cloneWith(array $fields): static` | Clone with field overrides |
| `except(array $keys): array` | Get array excluding specified fields |

## Real-World Examples

### HTTP API Response

```php
Route::get('/user/{id}', function (Request $request) {
    $user = User::find($request->id);
    return response()->json($user->toArray());
});
```

### Queue Job

```php
dispatch(new SendEmailJob($user->toJson()));

class SendEmailJob
{
    public function handle()
    {
        $user = UserDTO::fromJSON($this->userData);
        Mail::to($user->email)->send(new WelcomeEmail($user));
    }
}
```

### Domain Model Conversion

```php
// Map DTO to Eloquent model for persistence
$userModel = $userDTO->to(UserDTOToModel::class);
$userModel->save();
```

### Filtering Sensitive Data

```php
// Remove email before caching user data
$cacheData = $user->except(['email']);
Cache::put("user.{$user->name}", $cacheData);
```

## Documentation

For in-depth guides, visit the full [documentation](https://github.com/DevDanielAlvarez/ConcreteDTO).

Topics covered:
- **Getting Started** - Installation and first DTO
- **Importing Data** - Arrays, JSON, and custom converters
- **Exporting Data** - Output formats and domain mapping
- **Immutability** - Safe updates and field filtering

## Testing

```bash
composer test
```

Runs tests with Pest PHP.

## License

This library is open-sourced software licensed under the [MIT license](LICENSE).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

<div align="center">

**[⬆ back to top](#concretedto)**

</div>
