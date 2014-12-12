<?php

namespace Shop\BonusCardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;

class ShopBonusCardBundle extends Bundle
{
	public function boot()
    {
        if (!Type::hasType("enumcardstatus")) {
        	Type::addType('enumcardstatus', 'Shop\BonusCardBundle\DBAL\EnumCardStatusType');
        }
    }
}
