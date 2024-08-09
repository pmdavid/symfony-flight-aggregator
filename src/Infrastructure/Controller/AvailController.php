<?php

namespace App\Infrastructure\Controller;

use App\Application\Exception\InvalidParamsException;
use App\Application\GetAvailabilityPrice;
use App\Application\Validator\AvailabilityRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AvailController extends AbstractController
{
    private GetAvailabilityPrice $getAvailabilityPrice;
    private TestAPIClient $testAPIClient;
    private AvailabilityRequestValidator $availabilityRequestValidator;

    public function __construct(GetAvailabilityPrice $getAvailabilityPrice, TestAPIClient $testAPIClient, AvailabilityRequestValidator $availabilityRequestValidator)
    {
        $this->getAvailabilityPrice         = $getAvailabilityPrice;
        $this->testAPIClient                = $testAPIClient;
        $this->availabilityRequestValidator = $availabilityRequestValidator;
    }

  #[Route('/api/avail', name: 'app_index', methods: ['GET'])]
  public function index(Request $request): JsonResponse
  {
      $inputData = [
          'origin' => $request->query->get('origin'),
          'destination' => $request->query->get('destination'),
          'date' => $request->query->get('date'),
      ];

      try {
          $this->availabilityRequestValidator->validate($inputData);
      } catch (InvalidParamsException $e) {
          return $this->handleValidationException($e);
      }

      $segmentsData = $this->getSegmentsData($inputData);

      return $this->json($segmentsData);
  }

    private function getSegmentsData(array $inputData): array
    {
        return $this->getAvailabilityPrice->get(
            $this->testAPIClient,
            $inputData['origin'],
            $inputData['destination'],
            $inputData['date']
        );
    }

    private function handleValidationException(InvalidParamsException $e): JsonResponse
    {
        return $this->json([
            'message' => $e->getMessage(),
            'errors' => $e->getErrors()
        ], $e->getStatusCode());
    }
}
