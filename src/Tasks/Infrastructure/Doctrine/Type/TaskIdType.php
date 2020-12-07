<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type\IdentityType;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;

/**
 * Class TaskIdType
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\Type
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
