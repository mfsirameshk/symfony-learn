<?php 

namespace Ramesh\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ODM\MongoDB\DocumentRepository;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'document', array('label' => 'Group Name', 
					  'attr' => array('class' => 'group'),
					  'class' => 'RameshBlogBundle:Group',
					  'property' => 'name',
					  'empty_value'=> 'Please Select',
					  'multiple'=>false,
					  /*'query_builder' => function(DocumentRepository $er) {
											return $er->createQueryBuilder('u')
												->sort('u.name', 'DESC');
									},*/
					  ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ramesh\BlogBundle\Document\Group',
        ));
    }

    public function getName()
    {
        return 'group';
    }
}
