<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\SymfonyListeners;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\DomainException;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

/**
 * Class ExceptionListener
 * @package IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\SymfonyListeners
 */
class ExceptionListener implements EventSubscriberInterface
{
    /** @var SerializerInterface */
    private SerializerInterface $serializer;

    /**
     * ExceptionListener constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        if (
            strpos($request->getPathInfo(), '/api/doc') === 0 ||
            strpos($request->getPathInfo(), '/api/') !== 0
        ) {
            return;
        }

        $throwable = $event->getThrowable();
        if ($throwable instanceof HandlerFailedException && \count($throwable->getNestedExceptions()) > 0) {
            $throwable = $throwable->getNestedExceptions()[0];
        }

        if ($throwable instanceof DomainException) {
            $error = $this->serializer->serialize(Error::wrap($throwable), 'json');
            if ($throwable instanceof EntityNotFoundException) {
                $event->setResponse(
                    new JsonResponse($error, Response::HTTP_NOT_FOUND, [], true)
                );
            } else {
                $event->setResponse(
                    new JsonResponse($error, Response::HTTP_BAD_REQUEST, [], true)
                );
            }
        }
    }
}
