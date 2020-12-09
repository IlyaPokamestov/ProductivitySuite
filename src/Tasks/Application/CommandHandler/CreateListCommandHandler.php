<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Exception\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;

/**
 * Class CreateListCommandHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler
 */
class CreateListCommandHandler implements CommandHandlerInterface
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
     * @param CreateList $createList
     * @throws OwnershipMismatchException
     */
    public function __invoke(CreateList $createList): void
    {
        $ownerId = new OwnerId($createList->getOwnerId());
        if (TaskList::DEFAULT_LIST_NAME !== $createList->getName()) {
            $this->ownerRegisteredPolicy->verify($ownerId);
        }

        $list = TaskList::create(
            $createList->getId(),
            $createList->getName(),
            $ownerId,
        );

        $this->listRepository->save($list);
    }
}
