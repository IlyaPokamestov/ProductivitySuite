<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\DomainException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Exception\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;

/**
 * Class RemoveListCommandHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler
 */
class RemoveListCommandHandler implements CommandHandlerInterface
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
    public function __invoke(RemoveList $removeList): void
    {
        $list = $this->listRepository->findById(new ListId($removeList->getId()));
        $this->ownerRegisteredPolicy->verify($list->getOwnerId());

        if (TaskList::DEFAULT_LIST_NAME === $list->getName()) {
            throw new DomainException('Tasks list can not be removed!');
        }

        $list->remove();
        $this->listRepository->save($list);
    }
}
