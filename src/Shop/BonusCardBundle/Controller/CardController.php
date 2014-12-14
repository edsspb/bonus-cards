<?php

namespace Shop\BonusCardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Shop\BonusCardBundle\Entity\Cards;

class CardController extends DefaultController
{
   /**
    * @Route("/auth", name="admin_auth")
    * @Template()
    */
    public function authAction(Request $request)
    {
        if (false !== $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('card_main'));
        }

        $form = $this->createForm('authform', null, array(
            'action' => $this->generateUrl('admin_login_check'),
            'method' => 'POST',
        ));

        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        else
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);

        return [
            'error' => $error,
            'form' => $form->createView()
        ];
    }

    /**
    * @Route("/", name="card_main")
    * @Template()
    */
    public function indexAction(Request $request)
    {
        return [];
    }

    /**
    * @Route("/make/", name="card_make")
    * @Template()
    */
    public function makeAction(Request $request)
    {
        $form = $this->createForm('makecardsform', null, array(
            'action' => $this->generateUrl('card_make'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);

        if($form->isValid()) {
            $data = $request->request->all()['makecardsform'];
            $params = $this->container->getParameter('cards')['make'];
            // if(!$data['rand']) {
            //     $cardsRep = $this->getDoctrine()->getRepository('ShopBonusCardBundle:Cards');
            //     if(!($initNumber = $cardsRep->getMaxNumber())) {
            //         $initNumber = $params['init_value'];
            //     }
            // }
            echo '<pre>'; print_r($data); die();
            $em = $this->getDoctrine()->getManager(); 
            foreach($data as $item) {
                if(!$data['rand']) {
                    $initNumber++;
                } else {
                    $initNumber = rand($params['rand_min_value'], $params['rand_max_value']);
                }

                $cards = new Cards();
                $cards->setNumber($initNumber);
                $em->persist($cards);
            }
            $em->flush();
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
    * @Route("/show/", name="card_show")
    * @Template()
    */
    public function showAction(Request $request)
    {
        return [];
    }

    /**
    * @Route("/series/get/", name="card_series_get")
    * @Template()
    */
    public function getSeriesAction()
    {
        return new JsonResponse($this->getCardsManager()->cardsSeries());
    }
}