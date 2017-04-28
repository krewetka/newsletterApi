<?php

namespace NewsletterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
