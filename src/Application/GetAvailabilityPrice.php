<?php

namespace App\Application;

use App\Domain\AvailabilityPriceInterface;

class GetAvailabilityPrice
{
    public function get(AvailabilityPriceInterface $availabilityPriceRepository, string $origin, string $destination, string $date): array
    {
        return $availabilityPriceRepository->get($origin, $destination, $date);
    }
}


