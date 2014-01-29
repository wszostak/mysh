<?php
namespace xis\ShopCoreBundle\Tests\Domain\Cart;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Domain\Cart\Cart;
use xis\ShopCoreBundle\Domain\Cart\CartItem;

class CartTest extends ProphecyTestCase
{
    /** @var Cart */
    private $cart;

    public function setup()
    {
        parent::setup();
        $this->cart = new Cart();
    }

    /**
     * @test
     */
    public function shouldAddItemToItemsCollection()
    {
        $cartItem = new CartItem();
        $cartItem->setProductId(123);
        $cartItem->setProductName('blah');
        $cartItem->setQuantity(1);

        $this->cart->addItem($cartItem);

        $this->assertEquals(1, count($this->cart->getItems()));
        $this->assertEquals($cartItem, $this->cart->getItem(123));
    }

    /**
     * @test
     */
    public function shouldIncreaseQuantityWhenAddingSameItem()
    {
        $item1 = new CartItem();
        $item1->setProductId(123);
        $item1->setQuantity(10);

        $item2 = new CartItem();
        $item2->setProductId(123);
        $item2->setQuantity(2);

        $this->cart->addItem($item1);
        $this->cart->addItem($item2);

        $this->assertEquals(12, $this->cart->getItem(123)->getQuantity());
    }

    /**
     * @test
     */
    public function shouldRemoveItem()
    {
        $item1 = new CartItem();
        $item1->setProductId(123);
        $item1->setQuantity(10);
        $this->cart->addItem($item1);

        $this->cart->removeItem(123);

        $this->assertEquals(0, count($this->cart->getItems()));
    }

    /**
     * @test
     */
    public function shouldReplaceOldItemWhenModify()
    {
        $item1 = new CartItem();
        $item1->setProductId(123);
        $item1->setQuantity(10);
        $this->cart->addItem($item1);

        $item2 = new CartItem();
        $item2->setProductId(123);
        $item2->setQuantity(2);

        $this->cart->modifyItem($item2);

        $this->assertEquals($item2, $this->cart->getItem(123));
    }
} 