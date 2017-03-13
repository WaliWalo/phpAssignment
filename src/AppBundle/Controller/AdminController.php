<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/3/2017
 * Time: 12:49 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
/**
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     *
     * @Route("/",name="admin_index")
     */
    public function indexAction(Request $request)
    {
        $session = new Session();

        if($session->has('user')){
            return $this->render('admin/index.html.twig',[]);
        }

        $session->getFlashBag()->clear();
        $this->addFlash(
            'error',
            'Please login before accessing admin'
        );

        return $this->redirectToRoute('login');
    }
}