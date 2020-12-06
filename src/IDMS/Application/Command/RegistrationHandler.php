<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Command;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Email;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Name;

/**
 * Class RegistrationHandler
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Command
 */
class RegistrationHandler
{
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

    public function __invoke(RegisterConsumer $registerConsumer)
    {
        $consumer = Consumer::register(
            //TODO: Replace with generator.
            ConsumerId::generate(),
            new Name(
                $registerConsumer->getUsername(),
                $registerConsumer->getFirstName(),
                $registerConsumer->getLastName()
            ),
            new Email($registerConsumer->getEmail())
        );

        $this->consumerRepository->save($consumer);
    }
}
