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

final class PatientDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $email,
        public readonly ?string $birthday = null,
    ) {}
}
```

## Create instances

### From an array (fastest)

```php
$patient = PatientDTO::fromArray([
    'email' => 'patient@example.com',
    'birthday' => '1990-01-01',
]);
```

### From JSON

```php
$json = '{"email":"patient@example.com"}';
$patient = PatientDTO::fromJSON($json);
```

### From any type with a converter

Implement `DTOFrom` to describe how to turn a custom object into your DTO.

```php
<?php

use Alvarez\ConcreteDto\Contracts\DTOFrom;
use Alvarez\ConcreteDto\Contracts\IsDTO;

final class PatientRecord
{
    public function __construct(
        public readonly string $email,
        public readonly string $dob,
    ) {}
}

final class PatientRecordToDTO implements DTOFrom
{
    public static function handle(mixed $dataToConvert): IsDTO
    {
        return new PatientDTO(
            email: $dataToConvert->email,
            birthday: $dataToConvert->dob,
        );
    }
}

$record = new PatientRecord('patient@example.com', '1990-01-01');
$patient = PatientDTO::from(PatientRecordToDTO::class, $record);
```

## Export and update quickly

Every DTO can be exported with `toArray()`, `toJson()`, or converted to another shape with `to(DTOTo::class)`. Use `cloneWith([...])` to keep immutability while changing selected fields.

Next: dive into [Importing Data](/import) and [Exporting Data](/export).
