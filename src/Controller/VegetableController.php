<?php

namespace App\Controller;

use App\Entity\Vegetable;
use App\Service\VegetableService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\DTO\CreateVegetableDtoFactory;

#[Route('/vegetables')]
class VegetableController extends AbstractController
{
    public function __construct(private VegetableService $service)
    {
    }

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $vegetables = $this->service->getAll();

        $data = array_map(fn(Vegetable $v) => [
            'id' => $v->getId(),
            'name' => $v->getName(),
            'type' => $v->getType(),
            'season' => $v->getSeason(),
            'description' => $v->getDescription(),
        ], $vegetables);

        return $this->json($data);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Vegetable $vegetable): JsonResponse
    {
        return $this->json([
                               'id' => $vegetable->getId(),
                               'name' => $vegetable->getName(),
                               'type' => $vegetable->getType(),
                               'season' => $vegetable->getSeason(),
                               'description' => $vegetable->getDescription(),
                           ]);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $dto = CreateVegetableDtoFactory::fromRequest($request);
        $vegetable = $this->service->create($dto);

        return $this->json([
                               'message' => 'Vegetable created',
                               'id' => $vegetable->getId(),
                           ], 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, Vegetable $vegetable): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->service->update($vegetable, $data);

        return $this->json(['message' => 'Vegetable updated']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Vegetable $vegetable): JsonResponse
    {
        $this->service->delete($vegetable);

        return $this->json(['message' => 'Vegetable deleted']);
    }
}
