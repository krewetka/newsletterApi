<?php

namespace NewsletterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use  Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array('label' => 'article title'));
        $builder->add('body', TextType::class, array('label' => 'article body'));
        $builder->add('week', NumberType::class, array('label' => 'week number','invalid_message'=> "This value must be a number"));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NewsletterBundle\Entity\Article',
            'csrf_protection'   => false
        ));
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getBlockPrefix()
    {
        return '';
    }

    public function getName()
    {
        return '';
    }


}
