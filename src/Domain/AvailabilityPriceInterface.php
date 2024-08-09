<?php

namespace App\Domain;

interface AvailabilityPriceInterface
{
    public function get(string $origin, string $destination, string $date): array;
}
