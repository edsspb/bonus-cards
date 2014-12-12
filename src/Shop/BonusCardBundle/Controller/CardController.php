<?php

namespace Shop\BonusCardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
}