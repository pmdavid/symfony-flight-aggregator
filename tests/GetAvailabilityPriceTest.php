<?php


namespace App\Tests;

use App\Application\GetAvailabilityPrice;
use App\Domain\AvailabilityPriceInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class GetAvailabilityPriceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGet()
    {
        $mockRepository = $this->createMock(AvailabilityPriceInterface::class);

        $origin = 'MAD';
        $destination = 'BIO';
        $date = '2022-06-01';

        $expectedData = [
            [
                "originCode" => "MAD",
                "originName" => "Madrid Adolfo Suarez-Barajas",
                "destinationCode" => "BIO",
                "destinationName" => "Bilbao",
                "start" => "2022-06-01 07:40:00",
                "end" => "2022-06-01",
                "companyCode" => "IB",
                "companyName" => "Iberia",
                "transportNumber" => "0448"
            ],
        ];

        $mockRepository->expects($this->once())
            ->method('get')
            ->with($origin, $destination, $date)
            ->willReturn($expectedData);

        // Instantiating use case and testing it
        $getAvailabilityPrice = new GetAvailabilityPrice();

        $result = $getAvailabilityPrice->get($mockRepository, $origin, $destination, $date);
        $this->assertEquals($expectedData, $result);
    }
}

