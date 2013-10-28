<?php

namespace Ramesh\Bundle\ExpiryFieldBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class ExpiryDateTransformer implements DataTransformerInterface
{
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

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  $ccExp|null 
     * @return array
     */
    public function transform($ccExp)
    {
        if(isset($ccExp['day'])) {
            unset($ccExp['day']);
        }
        return $ccExp;
    }
    
    public  function reverseTransform($ccExp) {
        $lastDayofMonth = date('t', mktime(0, 0, 0, $ccExp['month'], 1, $ccExp['year']));
        $ccExp['day'] = $lastDayofMonth;
        return $ccExp;
    }
}