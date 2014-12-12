<?php

namespace Shop\BonusCardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\Debug\Debug,
	Symfony\Component\DependencyInjection\ContainerInterface,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
	public function setContainer(ContainerInterface $container = null)
	{
        parent::setContainer($container);
    }

    /**
     * @return CardsManager
     */
    protected function getCardsManager()
    {
        return $this->container->get('shop_bonus_card.cards_manager');
    }
}