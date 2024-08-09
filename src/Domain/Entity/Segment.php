<?php

namespace App\Domain\Entity;

class Segment
{
    /**
     * Origin IATA code, for example PMI
     * @var string
     * @example PMI
     */
    private string $originCode;

    /**
     * Origin name, for example Palma de Mallorca
     * @var string
     * @example Palma de Mallorca
     */
    private string $originName;

    /**
     * Destination IATA code, for example MAD
     * @var string
     * @example MAD
     */
    private string $destinationCode;

    /**
     * Destination IATA code, for example MAD
     * @var string
     * @example Madrid Adolfo Suárez Barajas
     */
    private string $destinationName;

    /**
     * Departure date time
     * @var \DateTime
     */
    private \DateTime $start;

    /**
     * Arrival date time
     * @var \DateTime
     */
    private \DateTime $end;

    /**
     * Transport or flight number
     * @var string
     * @example 3975
     */
    private string $transportNumber;

    /**
     * Company / airline code
     * @var string
     * @example IB
     */
    private string $companyCode;

    /**
     * Company / airline name
     * @var string
     * @example Iberia
     */
    private string $companyName;

    /**
     * @return string
     */
    public function getOriginCode(): string
    {
        return $this->originCode;
    }

    /**
     * @param string $originCode
     * @return Segment
     */
    public function setOriginCode(string $originCode): Segment
    {
        $this->originCode = $originCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginName(): string
    {
        return $this->originName;
    }

    /**
     * @param string $originName
     * @return Segment
     */
    public function setOriginName(string $originName): Segment
    {
        $this->originName = $originName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationCode(): string
    {
        return $this->destinationCode;
    }

    /**
     * @param string $destinationCode
     * @return Segment
     */
    public function setDestinationCode(string $destinationCode): Segment
    {
        $this->destinationCode = $destinationCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationName(): string
    {
        return $this->destinationName;
    }

    /**
     * @param string $destinationName
     * @return Segment
     */
    public function setDestinationName(string $destinationName): Segment
    {
        $this->destinationName = $destinationName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     * @return Segment
     */
    public function setStart(\DateTime $start): Segment
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     * @return Segment
     */
    public function setEnd(\DateTime $end): Segment
    {
        $this->end = $end;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransportNumber(): string
    {
        return $this->transportNumber;
    }

    /**
     * @param string $transportNumber
     * @return Segment
     */
    public function setTransportNumber(string $transportNumber): Segment
    {
        $this->transportNumber = $transportNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyCode(): string
    {
        return $this->companyCode;
    }

    /**
     * @param string $companyCode
     * @return Segment
     */
    public function setCompanyCode(string $companyCode): Segment
    {
        $this->companyCode = $companyCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return Segment
     */
    public function setCompanyName(string $companyName): Segment
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'originCode' => $this->getOriginCode(),
            'originName' => $this->getOriginName(),
            'destinationCode' => $this->getDestinationCode(),
            'destinationName' => $this->getDestinationName(),
            'start' => $this->getStart()->format('Y-m-d H:i:s'),
            'end' => $this->getEnd()->format('Y-m-d'),
            'companyCode' => $this->getCompanyCode(),
            'companyName' => $this->getCompanyName(),
            'transportNumber' => $this->getTransportNumber()
        ];
    }
}
