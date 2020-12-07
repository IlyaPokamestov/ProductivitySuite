<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository as DomainListRepository;

/**
 * Class ListHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class ListHandler implements MessageSubscriberInterface
{
    /** @var ListRepository */
    public ListRepository $listRepository;
    /** @var OwnershipPolicy */
    public OwnershipPolicy $ownershipPolicy;

    /**
     * ListHandler constructor.
     * @param ListRepository $listRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(ListRepository $listRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->listRepository = $listRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * @param FindById $findById
     * @return TaskList
     */
    public function findById(FindById $findById): TaskList
    {
        //TODO: Find a better way how to verify ownership on view model.
        if ($this->listRepository instanceof DomainListRepository) {
            $listAggregate = $this->listRepository->findListById(new ListId($findById->getId()));

            $this->ownershipPolicy->verify($listAggregate);
        }


        return $this->listRepository->findById($findById->getId());
    }

    /** {@inheritDoc} */
    public static function getHandledMessages(): iterable
    {
        yield FindById::class => [
            'method' => 'findById',
        ];
    }
}
