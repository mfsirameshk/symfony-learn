<?php

namespace Ramesh\Bundle\ExpiryFieldBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Ramesh\Bundle\ExpiryFieldBundle\Form\DataTransformer\ExpiryDateTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpiryType extends AbstractType {

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $transformer = new ExpiryDateTransformer($this->om);
        $builder->addViewTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'years' => range(date('Y'), date('Y') + 20),
            'format' => 'MMyyyydd',
        ));
    }

    public function getParent() {
        return 'date';
    }

    public function getName() {
        return 'expiry';
    }

}
