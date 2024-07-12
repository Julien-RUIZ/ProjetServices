<?php

namespace App\EventListener;


use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

/**
 * For activation, set IS_MAINTENANCE to true.
 * The user must have the ROLE_ADMIN to access the site.
 */
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
        if(!empty($this->security->getUser())){
            $role = $this->security->getUser()->getRoles();
            if (self::IS_MAINTENANCE === true && !in_array(self::ROLE_MAINTENANCE, $role)){
                $response = new Response($this->twig->render('Maintenance/index.html.twig'));
                $event->setResponse($response);
            }
        }
    }
}
