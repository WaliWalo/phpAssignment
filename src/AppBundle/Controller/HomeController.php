<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/3/2017
 * Time: 11:43 AM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/",name="homePage")
     */
    public function showHome()
    {
        return $this->render('default/index.html.twig');
    }
}