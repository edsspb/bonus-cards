<?php

namespace Shop\BonusCardBundle\DBAL;

class EnumCardStatusType extends EnumType
{
    const ACTIVATED		 = "activated";
    const NONACTIVATED 	 = "nonactivated";
    const EXPIRED 		 = "expired";
    const ACTIVATED_TITLE = "активирована";
    const NONACTIVATED_TITLE = "не активирована";
    const EXPIRED_TITLE  = "просрочена";

    public function getValues() {
    	return [
    		self::ACTIVATED,
    		self::NONACTIVATED,
    		self::EXPIRED,
    	];
    }

    public static function getValuesTitles() {
    	return [
    		self::ACTIVATED => self::ACTIVATED_TITLE,
    		self::NONACTIVATED => self::NONACTIVATED_TITLE,
    		self::EXPIRED => self::EXPIRED_TITLE,
    	];
    }

    protected $name = 'enumcardstatus';
}