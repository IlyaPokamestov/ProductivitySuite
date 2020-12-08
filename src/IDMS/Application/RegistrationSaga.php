<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Email;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Name;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Status;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListCreated;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Class RegistrationSaga
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application
 *
 * Let's assume that during the registration we need to pre-setup other systems, like create a default "Tasks" list.
 */
class RegistrationSaga implements MessageSubscriberInterface
{
    private const DEFAULT_LIST_NAME = 'Tasks';

    /** @var ConsumerRepository */
    private ConsumerRepository $consumerRepository;

    /**
     * RegistrationHandler constructor.
     * @param ConsumerRepository $consumerRepository
     */
    public function __construct(ConsumerRepository $consumerRepository)
    {
        $this->consumerRepository = $consumerRepository;
    }

    /**
     * @param RegisterConsumer $registerConsumer
     * @return string
     */
    public function initiateRegistration(RegisterConsumer $registerConsumer): string
    {
        $consumer = Consumer::register(
            ConsumerId::generate(),
            new Name(
                $registerConsumer->getUsername(),
                $registerConsumer->getFirstName(),
                $registerConsumer->getLastName()
            ),
            new Email($registerConsumer->getEmail())
        );

        $this->consumerRepository->save($consumer);

        return (string) $consumer->getId();
    }

    /**
     * @param ListCreated $listCreated
     *
     * TODO: Ideally we shouldn't use domain event classes from other bounded contexts.
     * TODO: But at the moment I do not see how we can easily do that with Symfony Messenger.
     * TODO: Need more time to find a better solution here.
     */
    public function completeRegistration(ListCreated $listCreated)
    {
        if (self::DEFAULT_LIST_NAME !== $listCreated->getName()) {
            return;
        }

        $consumer = $this->consumerRepository->findById(new ConsumerId((string) $listCreated->getOwnerId()));
        if ($consumer->getStatus()->equal(Status::registrationInProgress())) {
            $consumer->completeRegistration();

            $this->consumerRepository->save($consumer);
        }
    }

    /** {@inheritDoc} */
    public static function getHandledMessages(): iterable
    {
        yield RegisterConsumer::class => [
            'method' => 'initiateRegistration',
            'bus' => 'idms.command.bus',
        ];

        yield ListCreated::class => [
            'method' => 'completeRegistration',
            'bus' => 'event.bus',
        ];
    }
}
