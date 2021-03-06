<?php
namespace xis\Shop\Entity;

use xis\Shop\Cart\CartInterface;
use xis\Shop\Cart\CartItemInterface;

class Cart implements CartInterface
{
    /** @var CartItemInterface[] */
    private $items = array();

    /**
     * @return CartItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param CartItemInterface $cartItem
     * @return null
     */
    public function addItem(CartItemInterface $cartItem)
    {
        $itemAlreadyInCart = $this->getItem($cartItem->getProductId());
        if ($itemAlreadyInCart) {
            $sumQuantity = $itemAlreadyInCart->getQuantity() + $cartItem->getQuantity();
            $itemAlreadyInCart->setQuantity($sumQuantity);
        } else {
            $this->placeItem($cartItem);
        }
    }

    /**
     * @param $productId
     * @return null
     */
    public function removeItem($productId)
    {
        unset($this->items[$productId]);
    }

    /**
     * @param $productId
     * @return CartItemInterface|null
     */
    public function getItem($productId)
    {
        if (isset($this->items[$productId])) {
            return $this->items[$productId];
        }
        return null;
    }

    /**
     * @param CartItemInterface $cartItem
     * @return null
     */
    public function modifyItem(CartItemInterface $cartItem)
    {
        $this->items[$cartItem->getProductId()] = $cartItem;
    }

    /**
     * @param CartItemInterface $cartItem
     */
    protected function placeItem(CartItemInterface $cartItem)
    {
        $this->items[$cartItem->getProductId()] = $cartItem;
    }

    /**
     * @return int
     */
    function getCount()
    {
        $cnt = 0;
        foreach ($this->items as $item) {
            $cnt += $item->getQuantity();
        }
        return $cnt;
    }

    /**
     * @return double
     */
    function getAmount()
    {
        $amount = 0;
        foreach ($this->items as $item) {
            $amount += $item->getQuantity() * $item->getPrice();
        }
        return $amount;
    }
}