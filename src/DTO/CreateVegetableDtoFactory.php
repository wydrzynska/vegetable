<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;

class CreateVegetableDtoFactory
{
    public static function fromRequest(Request $request): CreateVegetableDto
    {
        $data = json_decode($request->getContent(), true);

        return new CreateVegetableDto(
            name: $data['name'] ?? '',
            type: $data['type'] ?? '',
            season: $data['season'] ?? '',
            description: $data['description'] ?? null,
        );
    }
}