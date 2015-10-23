<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentTracker implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var int */
    protected $carrier;
    const CARRIER_UPS = 0;
    const CARRIER_USPS = 1;
    const CARRIER_FEDEX = 2;

    /** @var string */
    protected $trackingCode;

    /** @var string */
    protected $externalId;

    /** @var ShipmentRate */
    protected $shipmentRate;

    /** @var ShipmentLabel */
    protected $shipmentLabel;

    /**
     * @param int $carrier
     * @param string $trackingCode
     */
    public function __construct($carrier, $trackingCode)
    {
        $this->setCarrier($carrier);
        $this->trackingCode = (string) $trackingCode;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('carrier', new Assert\Choice([
            'choices' => array_keys(static::getCarrierMapping()),
            'message' => 'The carrier is not a valid choice',
        ]));

        $metadata->addPropertyConstraint('trackingCode', new Assert\NotBlank);
        $metadata->addPropertyConstraint('trackingCode', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 60,
        ]));

        $metadata->addPropertyConstraint('shipmentRate', new Assert\Valid);
        $metadata->addPropertyConstraint('shipmentLabel', new Assert\Valid);
    }

    /**
     * @param int $carrier
     */
    private function setCarrier($carrier)
    {
        $this->carrier = $carrier;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public static function getCarrierMapping()
    {
        return [
            static::CARRIER_UPS => 'UPS',
            static::CARRIER_USPS => 'USPS',
            static::CARRIER_FEDEX => 'FEDEX',
        ];
    }

    public function getTrackingCode()
    {
        return $this->trackingCode;
    }

    public function setShipmentRate(ShipmentRate $shipmentRate)
    {
        $this->shipmentRate = $shipmentRate;
    }

    public function getShipmentRate()
    {
        return $this->shipmentRate;
    }

    public function setShipmentLabel(ShipmentLabel $shipmentLabel)
    {
        $this->shipmentLabel = $shipmentLabel;
    }

    public function getShipmentLabel()
    {
        return $this->shipmentLabel;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = (string) $externalId;
    }
}