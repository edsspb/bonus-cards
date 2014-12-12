<?php

namespace Shop\BonusCardBundle\Services;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\Container;

class CardsManager
{
	/** @var  Registry */
    protected $doctrine;
    /** @var Container */
    protected $container;
    /** @var SecurityContext */
    protected $security;

	public function __construct(Registry $doctrine, Container $container, SecurityContext $security) {
		$this->doctrine = $doctrine;
		$this->container = $container;
		$this->security = $security;
		//$this->usersRep = $this->doctrine->getRepository('DenisDTestBundle:Users');
	}
}
