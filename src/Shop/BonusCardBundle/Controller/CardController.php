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
use Shop\BonusCardBundle\DBAL\EnumCardStatusType;

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
        $data = $cardsObjs = $errors = [];

        if($form->isValid()) {
            $data = $request->request->all()['makecardsform'];
            $params = $this->container->getParameter('cards')['make'];
            $cardsRep = $this->getDoctrine()->getRepository('ShopBonusCardBundle:Cards');
            $series = $data['series'];
            $initNumber = $cardsRep->getMaxNumber((int)$series);
            if(is_null($initNumber)) {
                $initNumber = (int)$params['init_value'];
            }
            $em = $this->getDoctrine()->getManager(); 
            for($i=0; $i<$data['quantity']; $i++) {
                try {
                    $initNumber++;
                    $cards = new Cards();
                    $cards->setNumber($initNumber);
                    $cards->setSeries($series);
                    $cards->setDateModify($data['validity']);
                    $em->persist($cards);
                    $cardsObjs[] = $cards;
                } catch (\Exception $e) {
                    $logger = $this->get('logger');
                    $logger->error($e->getMessage());
                    $errors[] = $params['errors']['generate'].$initNumber;
                    continue;
                }
            }
            try {
                $em->flush();
            } catch (\Exception $e) {
                $logger = $this->get('logger');
                $logger->error($e->getMessage());
                $errors[] = $params['errors']['save'];
                $cardsObjs = [];
            }
        }

        return [
            'form' => $form->createView(),
            'data' => $data,
            'cards' => $cardsObjs,
            'errors' => $errors,
            'statuses' => EnumCardStatusType::getValuesTitles(),
        ];
    }

    /**
    * @Route("/show/", name="card_show")
    * @Template()
    */
    public function showAction()
    {
        return [];
    }

    /**
    * @Route("/edit/{id}", requirements={"id" = "\d+"}, name="card_edit")
    * @Template()
    */
    public function editAction($id)
    {
        return [];
    }

    /**
    * @Route("/delete/{id}", requirements={"id" = "\d+"}, name="card_delete")
    * @Template()
    */
    public function deleteAction($id)
    {
        $cardsRep = $this->getDoctrine()->getRepository('ShopBonusCardBundle:Cards');
        if($card = $cardsRep->findOneById($id)) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($card);
                $em->flush();
                $result = 1;
            } catch (\Exception $e) {
                $logger = $this->get('logger');
                $logger->error($e->getMessage());
                $result = 0;
            }
        } else
            $result = 0;
        return new JsonResponse($result);
    }

    /**
    * @Route("/activate/{id}", requirements={"id" = "\d+"}, name="card_activate")
    * @Template()
    */
    public function activateAction($id)
    {
        $cardsRep = $this->getDoctrine()->getRepository('ShopBonusCardBundle:Cards');
        if($card = $cardsRep->findOneById($id)) {
            try {
                $em = $this->getDoctrine()->getManager();
                $card->setStatus(EnumCardStatusType::ACTIVATED);
                $em->persist($card);
                $em->flush();
                $result = 1;
            } catch (\Exception $e) {
                $logger = $this->get('logger');
                $logger->error($e->getMessage());
                $result = 0;
            }
        } else
            $result = 0;
        return new JsonResponse($result);
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