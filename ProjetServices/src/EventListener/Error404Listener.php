<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class Error404Listener
{
    public const STATUS404= 404;
    public function __construct(public readonly Environment $twig)
    {
    }
    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        $error = $event->getThrowable();
        if ($error instanceof HttpException) {
            $statusCode = $error->getStatusCode();
        }
        if ($statusCode === self::STATUS404){
            $resp = new Response($this->twig->render('Exception/Error404.html.twig'));
            $event->setResponse($resp);
        }
    }
}
