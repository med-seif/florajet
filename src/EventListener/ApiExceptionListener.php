<?php

namespace App\EventListener;

use App\Controller\Api\ApiArticleController;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiExceptionListener
{
    /**
     * Converts Exception to json response when API in invoked
     *
     * @param ExceptionEvent $event
     * @return void
     */
    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        $controllerAction = $event->getRequest()->attributes->get('_controller');
        $controllerName = explode('::', $controllerAction)[0];
        if ($controllerName !== ApiArticleController::class) {
            return;
        }
        $exceptionMessage = $event->getThrowable()->getMessage();
        $newResponse = new JsonResponse(
            $event->getThrowable()->getMessage(),
            500
        );
        $event->setResponse($newResponse);
    }
}
