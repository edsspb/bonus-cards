<?php

namespace Shop\BonusCardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;

class ShopBonusCardBundle extends Bundle
{
	public function boot()
    {
        if (!Type::hasType("enumcardstatus")) {
        	$em = $this->container->get('doctrine.orm.entity_manager');
        	Type::addType('enumcardstatus', 'Shop\BonusCardBundle\DBAL\EnumCardStatusType');
        	$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('EnumCardStatus','enumcardstatus');
        }
    }
}
