<?php

namespace Ramesh\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text', array('label' => 'Your Name', 'attr' => array('class' => 'username', 'autocomplete' => 'off')))
            ->add('email', 'text')
             ->add('password', 'password')
            ->add('gender', 'gender', array('empty_value' => 'Please Select', 'expanded' => false))
            ->add('age', 'integer')
            ->add('country', 'country', array('empty_value' => 'Please Select'))
            ->add('currency', 'currency', array('empty_value' => 'Please Select'))
            ->add('dob', 'birthday', array('empty_value' => 'Select', 'widget' => 'choice', 'format' => 'yyyy-MM-dd'))
            ->add('file', 'file')
            ->add('ccExp', 'expiry')
            //->add('group',new GroupType())
            ->add('agreement', 'checkbox', array('required' => true, 'mapped' => false))
            ->add('group', 'document', array('label' => 'Group Name',
                'attr' => array('class' => 'group'),
                'class' => 'RameshBlogBundle:Group',
                'property' => 'name',
                'empty_value' => 'Please Select',
                'multiple' => false,
                'required' => false
                /* 'query_builder' => function(DocumentRepository $er) {
                  return $er->createQueryBuilder('u')
                  ->sort('u.name', 'DESC');
                  }, */
            ))
            ->add('save', 'submit');
    }

    public function getName() {
        return 'user';
    }

}
