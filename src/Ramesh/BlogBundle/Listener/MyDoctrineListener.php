<?php

namespace Ramesh\BlogBundle\Listener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Ramesh\BlogBundle\Document\Post;

class MyDoctrineListener {

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getDocument();
        if ($entity instanceof Post) {
            if (!($entity->getCreatedAt())) {
                $entity->setCreatedAt(date('Y-m-d H:i:s'));
            }
        }
    }

}
