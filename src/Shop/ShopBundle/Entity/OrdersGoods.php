<?php

namespace Shop\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Shop\BonusCardBundle\Entity;

/**
 * OrdersGoods
 *
 * @ORM\Table(name="orders_goods")
 * @ORM\Entity(repositoryClass="Shop\ShopBundle\Repository\OrdersGoodsRepository")
 */
class OrdersGoods
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="orders_id", type="integer")
     * @Assert\NotBlank()
     */
    private $ordersId;

    /**
     * @var integer
     *
     * @ORM\Column(name="goods_id", type="integer")
     * @Assert\NotBlank()
     */
    private $goodsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="cnt", type="integer")
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     */
    private $cnt;

    /**
     * @var Goods
     *
     * @ORM\ManyToOne(targetEntity="Shop\ShopBundle\Entity\Goods", inversedBy="ordersGoods")
     * @ORM\JoinColumn(name="goods_id", referencedColumnName="id")
     */
    private $goods;

    /**
     * @var Orders
     *
     * @ORM\ManyToOne(targetEntity="Shop\ShopBundle\Entity\Orders", inversedBy="ordersGoods")
     * @ORM\JoinColumn(name="orders_id", referencedColumnName="id")
     */
    private $orders;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ordersId
     *
     * @param integer $ordersId
     * @return OrdersGoods
     */
    public function setOrdersId($ordersId)
    {
        $this->ordersId = $ordersId;

        return $this;
    }

    /**
     * Get ordersId
     *
     * @return integer 
     */
    public function getOrdersId()
    {
        return $this->ordersId;
    }

    /**
     * Set goodsId
     *
     * @param integer $goodsId
     * @return OrdersGoods
     */
    public function setGoodsId($goodsId)
    {
        $this->goodsId = $goodsId;

        return $this;
    }

    /**
     * Get goodsId
     *
     * @return integer 
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * Set cnt
     *
     * @param integer $cnt
     * @return OrdersGoods
     */
    public function setCnt($cnt)
    {
        $this->cnt = $cnt;

        return $this;
    }

    /**
     * Get cnt
     *
     * @return integer 
     */
    public function getCnt()
    {
        return $this->cnt;
    }

    /**
     * Set Goods
     *
     * @param Goods $goods
     * @return OrdersGoods
     */
    public function setGoods(Goods $goods)
    {
        $this->goods = $goods;

        return $this;
    }

    /**
     * Get Goods
     *
     * @return Goods 
     */
    public function getGoods()
    {
        return $this->goods;
    }

    /**
     * Set Orders
     *
     * @param Orders $orders
     * @return OrdersGoods
     */
    public function setOrders(Orders $orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get Orders
     *
     * @return Orders 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
