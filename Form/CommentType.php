<?php

namespace CPANA\BasicBlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('comment')
            ->add('approved', 'hidden', array('data' => '0',));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
     
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'CPANA\BasicBlogBundle\Entity\Comment'
            )
        );
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'cpana_basicblogbundle_comment';
    }
}