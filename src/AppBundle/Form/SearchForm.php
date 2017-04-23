<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22/4/2017
 * Time: 2:01 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Search', SearchType::class)
        ;
    }

}