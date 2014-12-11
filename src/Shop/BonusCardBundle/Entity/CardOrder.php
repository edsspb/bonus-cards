<?php

namespace Shop\BonusCardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardOrder
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CardOrder
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
     * @ORM\Column(name="id_card", type="integer")
     */
    private $idCard;

    /**
     * @var integer
     *
     * @ORM\Column(name="summ", type="integer")
     */
    private $summ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
}
