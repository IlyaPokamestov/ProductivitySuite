<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Class ListHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class ListHandler implements MessageSubscriberInterface
{
    /** @var ListRepository */
    public ListRepository $consumerRepository;

    /**
     * ListHandler constructor.
     * @param ListRepository $listRepository
     */
    public function __construct(ListRepository $listRepository)
    {
        $this->consumerRepository = $listRepository;
    }

    /**
     * @param FindById $findById
     * @return TaskList
     */
    public function findById(FindById $findById): TaskList
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
