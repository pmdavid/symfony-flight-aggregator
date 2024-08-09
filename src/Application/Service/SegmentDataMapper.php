<?php

namespace App\Application\Service;

use App\Domain\Entity\Segment;
use DateTime;
use DOMElement;

class SegmentDataMapper
{
    public function map(DOMElement $entry): array
    {
        $flight = new Segment();

        $flight->setOriginCode($this->getElementValue($entry, 'Departure', 'AirportCode'));
        $flight->setOriginName($this->getElementValue($entry, 'Departure', 'AirportName'));
        $flight->setDestinationCode($this->getElementValue($entry, 'Arrival', 'AirportCode'));
        $flight->setDestinationName($this->getElementValue($entry, 'Arrival', 'AirportName'));

        $startDateTime = $this->parseDateTime(
            $this->getElementValue($entry, 'Departure', 'Date'),
            $this->getElementValue($entry, 'Departure', 'Time')
        );
        $flight->setStart($startDateTime);

        $endDateTime = $this->parseDate(
            $this->getElementValue($entry, 'Arrival', 'Date')
        );
        $flight->setEnd($endDateTime);

        $flight->setCompanyCode($this->getElementValue($entry, 'MarketingCarrier', 'AirlineID'));
        $flight->setCompanyName($this->getElementValue($entry, 'MarketingCarrier', 'Name'));
        $flight->setTransportNumber($this->getElementValue($entry, 'MarketingCarrier', 'FlightNumber'));

        return $flight->toArray();
    }

    private function getElementValue(DOMElement $entry, string $section, string $field): string
    {
        return $entry->getElementsByTagName($section)
            ->item(0)
            ->getElementsByTagName($field)
            ->item(0)
            ->nodeValue;
    }

    private function parseDateTime(string $date, string $time): DateTime
    {
        return DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
    }

    private function parseDate(string $date): DateTime
    {
        return DateTime::createFromFormat('Y-m-d', $date);
    }
}

