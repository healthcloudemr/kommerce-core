<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\AbstractCartPriceRuleItemDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractCartPriceRuleItem implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $quantity;

    /** @var CartPriceRule */
    protected $cartPriceRule;

    abstract public function matches(CartItem $cartItem);

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRule = $cartPriceRule;
    }

    public function getCartPriceRule()
    {
        return $this->cartPriceRule;
    }

    /**
     * @return AbstractCartPriceRuleItemDTOBuilder
     */
    abstract public function getDTOBuilder();
}