<?php

namespace Shop\BonusCardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class MakeCardsType extends AbstractType
{
    /** @var  Registry */
    protected $doctrine;
    /** @var Container */
    protected $container;
    /** @var SecurityContext */
    protected $security;

    public function __construct(Registry $doctrine, Container $container, SecurityContext $security)
    {
    	$this->doctrine = $doctrine;
		$this->container = $container;
		$this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$params = $this->container->getParameter('cards')['make'];

		$builder
		->add('quantity', 'number', [
			'label' => 'Количество',
			'required' => true,
			'attr' => [
				'max' => $params['max_quantity'],
				'min' => $params['min_quantity'],
				'maxlength' => strlen((string)$params['max_quantity'])
			],
			'invalid_message' => $params['constraints']['quantity_invalid'],
			'constraints' => array(
	            new Assert\GreaterThan(array(
            		'value' => $params['min_quantity'],
            		'message' => $params['constraints']['quantity_min'].$params['min_quantity']
        		)),
	            new Assert\LessThanOrEqual(array(
            		'value' => $params['max_quantity'],
            		'message' => $params['constraints']['quantity_max'].$params['max_quantity']
        		)),
	        )
		])
		->add('validity', 'choice', [
			'choices' => array_combine($params['validity']['keys'], $params['validity']['values']),
			'label' => 'Срок окончания активности',
			'required' => true,
			'expanded' => false,
  			'multiple' => false
		])
		->add('series', 'number', [
			'label' => 'Серия',
			'required' => true,
			'invalid_message' => $params['constraints']['series_invalid'],
		])
		->add('save', 'submit', ['label' => 'Создать бонусные карты']);
	}

    public function getName()
    {
		return 'makecardsform';
    }
}
