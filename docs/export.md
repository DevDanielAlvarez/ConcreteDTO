# Exporting Data

ConcreteDTO makes it easy to move DTO data into formats your application expects. Keep export logic explicit and testable by using the helpers below.

## `toArray(): array`

Returns a flat associative array based on the DTO constructor properties.

```php
<?php

$patient = new PatientDTO(
    email: 'alvarez@alvarez.com',
    birthday: '2000-01-01',
);

$array = $patient->toArray();
// ['email' => 'alvarez@alvarez.com', 'birthday' => '2000-01-01']
```

## `toJson(): string`

Serializes the DTO to JSON. Useful for HTTP responses or logging.

```php
$json = $patient->toJson();
// {"email":"alvarez@alvarez.com","birthday":"2000-01-01"}
```

## `to(DTOTo|string $conversor): mixed`

Convert the DTO into any custom structure by implementing `DTOTo`. This keeps mapping logic reusable and decoupled from controllers.

```php
<?php

use Alvarez\ConcreteDto\Contracts\DTOTo;
use Alvarez\ConcreteDto\Contracts\IsDTO;

final class PatientDTOToModel implements DTOTo
{
    public static function handle(IsDTO $dto): mixed
    {
        return new PatientModel(email: $dto->email, birthday: $dto->birthday);
    }
}

$patient = new PatientDTO(email: 'alvarez@alvarez.com', birthday: '2000-01-01');
$model = $patient->to(PatientDTOToModel::class);
```

By centralizing export rules, you avoid duplicated array casts scattered across the codebase and keep changes localized to your DTOs.
