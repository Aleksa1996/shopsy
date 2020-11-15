<?php


namespace App\Shopsy\Users\Infrastructure\Delivery\API\Symfony\EventSubscriber;


use App\Shopsy\Users\Infrastructure\Delivery\API\Symfony\Exception\RequestValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @return array|\array[][]
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::EXCEPTION => [
                ['processException', 10]
            ],
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function processException(ExceptionEvent $event)
    {
        $request = $event->getRequest();
        $exception = $event->getThrowable();

        if ($exception instanceof RequestValidationException) {
            $event->setResponse(new JsonResponse(
                ['violations' => $exception->getViolationListAsArray()],
                Response::HTTP_BAD_REQUEST
            ));
        }
    }
}