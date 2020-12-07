<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;

/**
 * Class CreateListHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command
 */
class CreateListHandler
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
     * @return string
     * @throws OwnershipMismatchException
     */
    public function __invoke(CreateList $createList): string
    {
        $ownerId = new OwnerId($createList->getOwnerId());
        $this->ownerRegisteredPolicy->verify($ownerId);

        $list = TaskList::create(
            ListId::generate(),
            $createList->getName(),
            $ownerId,
        );

        $this->listRepository->save($list);

        return (string) $list->getId();
    }
}
