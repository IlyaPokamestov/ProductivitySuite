<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\DomainException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;

/**
 * Class RemoveListHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList
 */
class RemoveListHandler implements CommandHandlerInterface
{
    /** @var ListRepository */
    private ListRepository $listRepository;
    /** @var OwnerRegisteredPolicy */
    private OwnerRegisteredPolicy $ownerRegisteredPolicy;

    /**
     * CreateListHandler constructor.
     * @param ListRepository $listRepository
     * @param OwnerRegisteredPolicy $ownerRegisteredPolicy
     */
    public function __construct(ListRepository $listRepository, OwnerRegisteredPolicy $ownerRegisteredPolicy)
    {
        $this->listRepository = $listRepository;
        $this->ownerRegisteredPolicy = $ownerRegisteredPolicy;
    }

    /**
     * @param RemoveList $removeList
     * @throws OwnershipMismatchException
     */
    public function __invoke(RemoveList $removeList)
    {
        $list = $this->listRepository->findListById(new ListId($removeList->getId()));
        $this->ownerRegisteredPolicy->verify($list->getOwnerId());

        if (TaskList::DEFAULT_LIST_NAME === $list->getName()) {
            throw new DomainException('Tasks list can not be removed!');
        }

        $list->remove();
        $this->listRepository->save($list);
    }
}
