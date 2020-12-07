<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;

/**
 * Class TaskIdType
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type
 */
class TaskIdType extends IdentityType
{
    protected const NAME = 'task_id';

    /** {@inheritDoc} */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new TaskId($value);
    }
}
