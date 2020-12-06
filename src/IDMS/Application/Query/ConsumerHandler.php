<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Query;

use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Class ConsumerHandler
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Query
 */
class ConsumerHandler implements MessageSubscriberInterface
{
    /** @var ConsumerRepository */
    public ConsumerRepository $consumerRepository;

    /**
     * ConsumerHandler constructor.
     * @param ConsumerRepository $consumerRepository
     */
    public function __construct(ConsumerRepository $consumerRepository)
    {
        $this->consumerRepository = $consumerRepository;
    }

    /**
     * @param FindById $findById
     * @return Consumer
     */
    public function findById(FindById $findById): Consumer
    {
        return $this->consumerRepository->findById($findById->getId());
    }

    /** {@inheritDoc} */
    public static function getHandledMessages(): iterable
    {
        yield FindById::class => [
            'method' => 'findById',
        ];
    }
}
