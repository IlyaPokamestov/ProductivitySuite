<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;

/**
 * Class ListIdType
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Type
 */
class ListIdType extends IdentityType
{
    protected const NAME = 'list_id';

    /** {@inheritDoc} */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ListId($value);
    }
}
