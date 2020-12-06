<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList;

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

    /**
     * CreateListHandler constructor.
     * @param ListRepository $listRepository
     */
    public function __construct(ListRepository $listRepository)
    {
        $this->listRepository = $listRepository;
    }

    /**
     * @param CreateList $createList
     */
    public function __invoke(CreateList $createList)
    {
        $list = TaskList::create(
            ListId::generate(),
            $createList->getName()
        );

        $this->listRepository->save($list);
    }
}
