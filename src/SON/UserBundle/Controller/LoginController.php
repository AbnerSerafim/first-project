<?php
/**
 * Created by PhpStorm.
 * User: Abner
 * Date: 29/04/14
 * Time: 00:00
 */

namespace SON\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     * @return array
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        $session->remove(SecurityContext::AUTHENTICATION_ERROR);

        return array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
} 