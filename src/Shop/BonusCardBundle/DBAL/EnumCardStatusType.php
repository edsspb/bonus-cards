<?php

namespace Shop\BonusCardBundle\DBAL;

class EnumCardStatusType extends EnumType
{
    protected $name = 'enumcardstatus';
    protected $values = ["active", "unactive", "expired"];
}