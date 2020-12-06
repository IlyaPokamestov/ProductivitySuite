<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\SymfonyListeners;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ResponseListener
 * @package IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\SymfonyListeners
 */
class ResponseListener implements EventSubscriberInterface
{
    protected const DEFAULT_HEADERS = ['Content-Type' => 'application/json'];
    protected const DEFAULT_STATUS_ERROR = Response::HTTP_BAD_REQUEST;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * ResponseListener constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /** @param ViewEvent $event */
    public function onKernelView(ViewEvent $event)
    {
        $result = $event->getControllerResult();

        $groups = $event->getRequest()->attributes->get('groups', []);
        $response = $this->toJson($result, $groups);

        if ($response) {
            $event->setResponse($response);
        }
    }

    /** {@inheritdoc} */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => 'onKernelView',
        ];
    }

    /**
     * Converts data to JSON format using JMS serializer.
     *
     * @param object|array $data
     * @param array $groups
     * @param int $status
     *
     * @return Response
     */
    private function toJson($data, array $groups = ['default'], int $status = Response::HTTP_OK): Response
    {
        $groups = $groups ? SerializationContext::create()->setGroups($groups) : null;

        return new Response(
            $this->serializer->serialize($data, 'json', $groups),
            $status,
            self::DEFAULT_HEADERS
        );
    }
}
