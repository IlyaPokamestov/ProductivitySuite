<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Trait OwnerableTrait
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner
 */
trait OwnerableTrait
{
    /**
     * @ORM\Column(type="owner_id")
     * @Serializer\Exclude()
     *
     * @var OwnerId
     */
    protected OwnerId $ownerId;

    /**
     * Returns owner id of the model.
     *
     * @return OwnerId
     */
    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }
}
