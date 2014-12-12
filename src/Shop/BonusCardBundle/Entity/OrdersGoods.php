<?php

namespace Shop\BonusCardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersGoods
 *
 * @ORM\Table()
 * @ORM\Entity
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
     */
    private $ordersId;

    /**
     * @var integer
     *
     * @ORM\Column(name="goods_id", type="integer")
     */
    private $goodsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="cnt", type="integer")
     */
    private $cnt;


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
}
