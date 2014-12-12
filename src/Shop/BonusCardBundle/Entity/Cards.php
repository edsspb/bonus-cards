<?php

namespace Shop\BonusCardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Shop\ShopBundle\Entity;

/**
 * Card
 *
 * @ORM\Table(name="cards")
 * @ORM\Entity(repositoryClass="Shop\BonusCardBundle\Repository\CardsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Cards
{
    public function __construct()
    {
        $this->orders = new ArrayCollection();
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
     * @ORM\Column(name="series", type="integer")
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     */
    private $series;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="datetime")
     * @Assert\DateTime()
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="datetime")
     * @Assert\DateTime()
     */
    private $enddate;

    /**
     * @var enumcardstatus
     *
     * @ORM\Column(name="status", type="enumcardstatus", options={"default":"active"})
     * @Assert\Choice({"active", "unactive", "expired"})
     */
    private $status;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Shop\ShopBundle\Entity\Orders", mappedBy="cards")
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
     * Set series
     *
     * @param integer $series
     * @return Card
     */
    public function setSeries($series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return integer 
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Card
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     * @return Card
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime 
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     * @return Card
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime 
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Card
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get ArrayCollection Cards::orders
     *
     * @return ArrayCollection Cards::orders 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /** @ORM\PrePersist */
    public function onCreate()
    {
        $this->startdate = new \DateTime();
        if(is_null($this->enddate))
            $this->enddate = $this->startdate->modify('+1 month');
    }
}
