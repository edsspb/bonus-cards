<?php

namespace Shop\BonusCardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;

class CardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', [
			'label' => 'Логин',
			'required' => true
		])
		->add('password', 'password', [
			'label' => 'Пароль',
			'required' => true,
		])
		->add('save', 'submit', ['label' => 'Вход']);
	}

    public function getName()
    {
		return 'cardsform';
    }
}
