<?php

namespace App\Infrastructure\Controller;

use App\Application\Service\SegmentDataMapper;
use App\Domain\AvailabilityPriceInterface;
use DOMDocument;
use DOMNodeList;
use DOMXPath;

class TestAPIClient implements AvailabilityPriceInterface
{
    private string $url;
    private SegmentDataMapper $segmentDataMapper;

    public function __construct(SegmentDataMapper $segmentDataMapper)
    {
        $this->url = 'https://testapi.lleego.com/prueba-tecnica/availability-price';
        $this->segmentDataMapper = $segmentDataMapper;
    }

    public function get(string $origin, string $destination, string $date): array
    {
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'date' => $date
        ];

        $responseData = $this->launchCurl($params);
        $xmlFlightsData = $this->processXMLData($responseData);

        return $this->extractFlightsData($xmlFlightsData);
    }


    /**
     * @param DOMNodeList $xmlData The XML data containing flight information.
     * @return array An array of flight data extracted from the XML.
     *
     * Extracts only the flight data we need from XML data, iterating over the XML nodes and maps the data to a
     * structured format suitable for processing
     */
    private function extractFlightsData(DOMNodeList $xmlData): array
    {
        $flights = [];

        foreach ($xmlData as $entry) {
            $flights[] = $this->segmentDataMapper->map($entry);
        }

        return $flights;
    }


    /**
     * @param string $dataToProcess The XML raw data
     * @return DOMNodeList
     *
     * Preparing and configuring XML for further data process
     */
    private function processXMLData(string $dataToProcess): DOMNodeList
    {
        $dom = new DOMDocument();
        $dom->loadXML($dataToProcess);
        $xpath = new DOMXPath($dom);

        // Registering required namespaces according to the data appearing in the xml
        $xpath->registerNamespace('ns', 'http://www.iata.org/IATA/EDIST/2017.2');
        $xpath->registerNamespace('ns2', 'http://www.iberia.com/IATA/NDC/SecurePayment/2017.2');
        $xpath->registerNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');

        // Selecting only the information we need according to the requirements of the task.
        $query = '//ns:AirShoppingRS/ns:DataLists/ns:FlightSegmentList/ns:FlightSegment';
        $entries = $xpath->query($query);

        return $entries;

    }
    private function launchCurl(array $params): string
    {
        $paramsString = http_build_query($params);
        $fullUrl = $this->url . '?' . $paramsString;

        $c = curl_init($fullUrl);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));

        $result = curl_exec($c);
        curl_close($c);

        return $result;
    }
}
