<?php

namespace App\Service;

use App\Entity\Vegetable;
use Doctrine\ORM\EntityManagerInterface;

class VegetableService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Vegetable::class)->findAll();
    }

    public function getById(int $id): ?Vegetable
    {
        return $this->em->getRepository(Vegetable::class)->find($id);
    }

    public function create(array $data): Vegetable
    {
        $vegetable = new Vegetable();
        $vegetable->setName($data['name'] ?? '');
        $vegetable->setType($data['type'] ?? '');
        $vegetable->setSeason($data['season'] ?? '');
        $vegetable->setDescription($data['description'] ?? null);

        $this->em->persist($vegetable);
        $this->em->flush();

        return $vegetable;
    }

    public function update(Vegetable $vegetable, array $data): Vegetable
    {
        $vegetable->setName($data['name'] ?? $vegetable->getName());
        $vegetable->setType($data['type'] ?? $vegetable->getType());
        $vegetable->setSeason($data['season'] ?? $vegetable->getSeason());
        $vegetable->setDescription($data['description'] ?? $vegetable->getDescription());

        $this->em->flush();

        return $vegetable;
    }

    public function delete(Vegetable $vegetable): void
    {
        $this->em->remove($vegetable);
        $this->em->flush();
    }
}
