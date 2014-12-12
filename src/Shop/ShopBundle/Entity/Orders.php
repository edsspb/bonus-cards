<?php

namespace Shop\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Shop\BonusCardBundle\Entity;

/**
 * CardOrder
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="Shop\ShopBundle\Repository\OrdersRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Orders
{
    public function __construct()
    {
        $this->ordersGoods = new ArrayCollection();
    }

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
     * @ORM\Column(name="cards_id", type="integer")
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     */
    private $cardsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="summ", type="integer")
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     */
    private $summ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var Cards
     *
     * @ORM\ManyToOne(targetEntity="Shop\BonusCardBundle\Entity\Cards", inversedBy="orders")
     * @ORM\JoinColumn(name="cards_id", referencedColumnName="id")
     */
    private $cards;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Shop\ShopBundle\Entity\OrdersGoods", mappedBy="orders")
     */
    private $ordersGoods;

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
     * Set idCard
     *
     * @param integer $idCard
     * @return CardOrder
     */
    public function setIdCard($idCard)
    {
        $this->idCard = $idCard;

        return $this;
    }

    /**
     * Get idCard
     *
     * @return integer 
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * Set summ
     *
     * @param integer $summ
     * @return CardOrder
     */
    public function setSumm($summ)
    {
        $this->summ = $summ;

        return $this;
    }

    /**
     * Get summ
     *
     * @return integer 
     */
    public function getSumm()
    {
        return $this->summ;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return CardOrder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set Cards
     *
     * @param Cards $cards
     * @return CardOrder
     */
    public function setCards(Cards $cards)
    {
        $this->cards = $cards;

        return $this;
    }

    /**
     * Get Cards
     *
     * @return Cards 
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Get ArrayCollection Orders::ordersGoods
     *
     * @return ArrayCollection Orders::ordersGoods 
     */
    public function getOrdersGoods()
    {
        return $this->ordersGoods;
    }

    /** @ORM\PrePersist */
    public function onCreate()
    {
        $this->date = new \DateTime();
    }
}
