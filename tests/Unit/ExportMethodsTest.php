<?php

use Alvarez\ConcreteDto\AbstractDTO;

class PatientDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $email
    ) {
    }
}

it('can convert a DTO to an array', function () {
    // create a patient DTO
    $patientDTO = new PatientDTO(email: 'alvarez@alvarez.com');
    // convert the DTO to an array
    $arrayWithData = $patientDTO->toArray();
    // $arrayWithData must be an array
    expect($arrayWithData)->toBeArray();
    // $arrayWithData must contain an email key equals to alvarez@alvarez.com
    expect($arrayWithData['email'])->toBe('alvarez@alvarez.com');
});