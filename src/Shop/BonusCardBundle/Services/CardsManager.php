<?php

namespace Shop\BonusCardBundle\Services;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\Container;
use Shop\BonusCardBundle\Repository\CardsRepository;

class CardsManager
{
	/** @var  Registry */
    protected $doctrine;
    /** @var Container */
    protected $container;
    /** @var SecurityContext */
    protected $security;
    /** @var CardsRepository */
    protected $cardsRep;

	public function __construct(Registry $doctrine, Container $container, SecurityContext $security) {
		$this->doctrine = $doctrine;
		$this->container = $container;
		$this->security = $security;
		$this->cardsRep = $this->doctrine->getRepository('ShopBonusCardBundle:Cards');
	}

	public function cardsSeries() {
		if($series = $this->cardsRep->getCardsSeries()) {
			$series = array_reduce($series, function($carry , $item) {
                $carry[] = current($item);
                return $carry;
            });
		}
		return $series;
	}
}
