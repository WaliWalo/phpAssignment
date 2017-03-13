<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/3/2017
 * Time: 12:19 PM
 */

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller
{
    /**
     * login form
     *
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($this->canAuthenticate($user)){
                $session = new Session();
                $session->set('user',$user);
                return $this->redirectToRoute('admin_index');
            }else{
                $this->addFlash('error','Wrong username or password.');
            }
        }

        $argsArray = [
            'user'=>$user,
            'form'=>$form->createView(),
        ];


        $templateName = 'default/login';
        return $this->render($templateName . '.html.twig',$argsArray);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function canAuthenticate(User $user){
        $username = $user->getUsername();
        $password = $user->getPassword();

        return('admin'==$username)&&('admin'==$password);
    }
}