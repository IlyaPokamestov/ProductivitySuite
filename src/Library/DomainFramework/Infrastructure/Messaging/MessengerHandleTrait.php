<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Trait MessengerHandleTrait
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging
 */
trait MessengerHandleTrait
{
    /**
     * Dispatches the given message, expecting to be handled by a single handler
     * and returns the result from the handler returned value.
     * This behavior is useful for both synchronous command & query buses,
     * the last one usually returning the handler result.
     *
     * @param MessageBusInterface $messageBus
     * @param object|Envelope $message The message or the message pre-wrapped in an envelope
     *
     * @return mixed The handler returned value
     * @throws \Throwable
     */
    private function handle(MessageBusInterface $messageBus, $message)
    {
        if (!$messageBus instanceof MessageBusInterface) {
            throw new LogicException(sprintf(
                'You must provide a "%s" instance in the "%s::$messageBus" property, "%s" given.',
                MessageBusInterface::class,
                static::class,
                get_debug_type($messageBus)
            ));
        }

        try {
            $envelope = $messageBus->dispatch($message);
        } catch (\Throwable $error) {
            throw $this->unwrapHandlerFailedException($error);
        }

        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);

        if (!$handledStamps) {
            throw new LogicException(sprintf(
                'Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".',
                get_debug_type($envelope->getMessage()),
                static::class,
                __FUNCTION__
            ));
        }

        if (count($handledStamps) > 1) {
            $handlers = implode(', ', array_map(function (HandledStamp $stamp): string {
                return sprintf('"%s"', $stamp->getHandlerName());
            }, $handledStamps));

            throw new LogicException(sprintf(
                'Message of type "%s" was handled multiple times. ' .
                'Only one handler is expected when using "%s::%s()", got %d: %s.',
                get_debug_type($envelope->getMessage()),
                static::class,
                __FUNCTION__,
                count($handledStamps),
                $handlers
            ));
        }

        return $handledStamps[0]->getResult();
    }

    /**
     * @param \Throwable $throwable
     * @return \Throwable
     */
    private function unwrapHandlerFailedException(\Throwable $throwable): \Throwable
    {
        if ($throwable instanceof HandlerFailedException && \count($throwable->getNestedExceptions()) > 0) {
            return $this->unwrapHandlerFailedException($throwable->getNestedExceptions()[0]);
        }

        return $throwable;
    }
}
