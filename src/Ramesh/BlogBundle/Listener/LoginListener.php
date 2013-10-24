<?php

namespace Ramesh\BlogBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry as Doctrine;

class LoginListener {

    protected $doctrine;

    public function __construct(Doctrine $doctrine) {
        $this->doctrine = $doctrine;
    }

    public function onLogin(InteractiveLoginEvent $event) {
        $user = $event->getAuthenticationToken()->getUser();
        if ($user) {
            $user->setLastLogin(date('Y-m-d H:i:s'));
            $user->setTotalLogins($user->getTotalLogins() + 1);
            $dm = $this->doctrine->getManager();
            $dm->flush();
        }
    }

}
