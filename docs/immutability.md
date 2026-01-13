# Immutability

DTOs are easiest to reason about when they stay immutable. ConcreteDTO helps you create adjusted copies without mutating the original instance.

## `cloneWith(array $fields): static`

Create a new DTO instance by merging existing properties with the provided overrides.

```php
<?php

$original = new PatientDTO(
    email: 'alvarez@alvarez.com',
    birthday: '2000-01-01',
);

$updated = $original->cloneWith([
    'email' => 'new@example.com',
]);

// $original->email remains 'alvarez@alvarez.com'
// $updated->email is 'new@example.com'
```

## `except(array $keys): array`

Get an array of DTO data while removing sensitive or unnecessary fields.

```php
$data = $updated->except(['birthday']);
// ['email' => 'new@example.com']
```

Combining `cloneWith()` and `except()` keeps DTO usage predictable, even as your data requirements evolve.
