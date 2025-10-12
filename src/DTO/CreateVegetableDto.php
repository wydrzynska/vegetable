<?php

namespace App\DTO;

class CreateVegetableDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $season,
        public readonly ?string $description = null,
    ) {}
}