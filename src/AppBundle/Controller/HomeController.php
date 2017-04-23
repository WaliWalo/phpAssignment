<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/3/2017
 * Time: 11:43 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Recipe;
use AppBundle\Form\SearchForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeController extends Controller
{
    /**
     * @Route("/",name="homePage")
     */
    public function showHome()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('AppBundle:Recipe')->findAll();

        return $this->render('default/index.html.twig', array(
            'recipes' => $recipes,
            'user'=>$user,
        ));

    }


    /**
     * @Route("/find",name="search")
     * @Method({"GET", "POST"})
     */
    public function search(Request $request){

        $form = $this->createForm(SearchForm::class);

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $recipe = new recipe();
        $recipes = $em->getRepository('AppBundle:Recipe')->findBy(array("title"=>$form["Search"]->getData()));
        if ($form->isSubmitted() && $form->isValid()) {


            return $this->render('default/find.html.twig', array(
                'recipe'=>$recipe,
                'recipes'=>$recipes,
                'form' => $form->createView(),
            ));
        }


        return $this->render('default/find.html.twig', array(
            'recipe'=>$recipe,
            'recipes'=>$recipes,
            'form' => $form->createView(),
        ));
    }
}