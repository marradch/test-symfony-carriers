<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $exception = $event->getThrowable();

        if ($exception instanceof UnprocessableEntityHttpException) {
            $previous = $exception->getPrevious();

            if ($previous instanceof ValidationFailedException) {
                $violations = $previous->getViolations();

                $errors = [];

                foreach ($violations as $violation) {
                    $field = $violation->getPropertyPath();

                    $errors[$field] = $violation->getMessage();
                }

                $response = new JsonResponse([
                    'message' => 'Validation failed',
                    'errors' => $errors
                ], 422);

                $event->setResponse($response);
            } else {
                $response = new JsonResponse([
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 422);

                $event->setResponse($response);
            }
        }
    }
}
