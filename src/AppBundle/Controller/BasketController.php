<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21/4/2017
 * Time: 12:01 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class BasketController
 * @package AppBundle\Controller
 * @Route("/basket")
 */
class BasketController extends Controller
{
    /**
     * @Route("/", name="basket_index")
     */
    public function indexAction()
    {
        $argsArray = [];

        $templateName = 'basket/index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/clear", name="basket_clear")
     */
    public function clearAction()
    {
        $session = new Session();
        $session->remove('basket');

        return $this->redirectToRoute('basket_index');
    }

    /**
     * @Route("/add/{id}", name="basket_add")
     */
    public function addToBasket(Recipe $recipe)
    {
        $recipes = [];

        $session = new Session();
        if($session->has('basket')){
            $recipes = $session->get('basket');
        }

        $id = $recipe->getId();

        if(!array_key_exists($id, $recipes)){
            $recipes[$id] = $recipe;
            $session->set('basket', $recipes);
        }

        return $this->redirectToRoute('basket_index');
    }

    /**
     * @Route("/delete/{id}", name="basket_delete")
     */
    public function deleteAction(int $id)
    {
        $recipes = [];

        $session = new Session();
        if($session->has('basket')){
            $recipes = $session->get('basket');
        }

        if(array_key_exists($id, $recipes)){
            unset($recipes[$id]);

            if(sizeof($recipes) < 1){
                return $this->redirectToRoute('basket_clear');
            }
            $session->set('basket', $recipes);
        }
        return $this->redirectToRoute('basket_index');
    }

}