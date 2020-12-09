<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Saga;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Repository\ConsumerRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Email;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Status;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\Event\ListCreated;
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
     */
    public function initiateRegistration(RegisterConsumer $registerConsumer): void
    {
        $consumer = Consumer::register(
            $registerConsumer->getId(),
            new Name(
                $registerConsumer->getUsername(),
                $registerConsumer->getFirstName(),
                $registerConsumer->getLastName()
            ),
            new Email($registerConsumer->getEmail())
        );

        $this->consumerRepository->save($consumer);
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
            'bus' => 'command.bus',
        ];

        yield ListCreated::class => [
            'method' => 'completeRegistration',
            'bus' => 'event.bus',
        ];
    }
}
