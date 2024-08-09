<?php

namespace App\Tests;

use App\Domain\Entity\Segment;
use PHPUnit\Framework\TestCase;

class SegmentTest extends TestCase
{
    public function testToArray()
    {
        $start = new \DateTime('2024-08-01 10:00:00');
        $end = new \DateTime('2024-08-01');

        $segment = (new Segment())
            ->setOriginCode('PMI')
            ->setOriginName('Palma de Mallorca')
            ->setDestinationCode('MAD')
            ->setDestinationName('Madrid Adolfo Suárez Barajas')
            ->setStart($start)
            ->setEnd($end)
            ->setTransportNumber('3975')
            ->setCompanyCode('IB')
            ->setCompanyName('Iberia');

        $expectedArray = [
            'originCode' => 'PMI',
            'originName' => 'Palma de Mallorca',
            'destinationCode' => 'MAD',
            'destinationName' => 'Madrid Adolfo Suárez Barajas',
            'start' => '2024-08-01 10:00:00',
            'end' => '2024-08-01',
            'companyCode' => 'IB',
            'companyName' => 'Iberia',
            'transportNumber' => '3975'
        ];

        $this->assertEquals($expectedArray, $segment->toArray());
    }
}

