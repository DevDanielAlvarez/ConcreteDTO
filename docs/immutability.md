# Immutability

DTOs are easiest to reason about when they stay immutable. ConcreteDTO helps you create adjusted copies without mutating the original instance.

Reach for these helpers when you want safe updates for queues, events, or retries without side effects.

## `cloneWith(array $fields): static`

Create a new DTO instance by merging existing properties with the provided overrides.

```php
<?php

$original = new UserDTO(
    name: 'Daniel Alvarez',
    email: 'alvarez@alvarez.com',
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
$data = $updated->except(['email']);
// ['name' => 'Daniel Alvarez']
```

Combining `cloneWith()` and `except()` keeps DTO usage predictable, even as your data requirements evolve.

> Tip: keep `cloneWith()` changes small—prefer creating a dedicated DTO for meaningfully different shapes.
