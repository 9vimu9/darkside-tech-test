<?php

namespace App\DTOs;

class CustomerDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email ,
        public readonly string $telephoneNumber,
        public readonly string $address,
    ){}

}
