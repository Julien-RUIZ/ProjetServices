<?php

namespace App\EventListener;


use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class MaintenanceListener
{
    public const IS_MAINTENANCE = false;
    public const ROLE_MAINTENANCE = 'ROLE_ADMIN';
    public function __construct(public readonly Security $security, public readonly Environment $twig)
    {
    }

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 1)]
    public function onKernelRequest(RequestEvent $event): void
    {
        //dd($this->security->getUser());

        if(!empty($this->security->getUser())){
            $role = $this->security->getUser()->getRoles();
            if (self::IS_MAINTENANCE === true && !in_array(self::ROLE_MAINTENANCE, $role)){
                $response = new Response($this->twig->render('maintenance/index.html.twig'));
                $event->setResponse($response);
            }
        }


    }
}
