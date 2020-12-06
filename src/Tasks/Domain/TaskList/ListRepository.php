<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList;

/**
 * Interface ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList
 */
interface ListRepository
{
    /**
     * Save list.
     *
     * @param TaskList $list
     */
    public function save(TaskList $list): void;
}
