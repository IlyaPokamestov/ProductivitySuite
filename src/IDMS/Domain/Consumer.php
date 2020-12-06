<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\AggregateRoot;

/**
 * Class Consumer
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 */
class Consumer extends AggregateRoot
{
    /** @var ConsumerId */
    private ConsumerId $id;
    /** @var Name */
    private Name $name;
    /** @var Email */
    private Email $email;

    /**
     * Register consumer.
     *
     * @param ConsumerId $id
     * @param Name $name
     * @param Email $email
     * @return static
     */
    public static function register(ConsumerId $id, Name $name, Email $email): self
    {
        return new static($id, $name, $email);
    }

    /**
     * Consumer constructor.
     * @param ConsumerId $id
     * @param Name $name
     * @param Email $email
     */
    public function __construct(ConsumerId $id, Name $name, Email $email)
    {
        $this->name = $name;
        $this->id = $id;
        $this->email = $email;

        $this->record(new ConsumerRegistered(
            $id->id(),
            $name->getUsername(),
            $name->getFirstName(),
            $name->getLastName(),
            (string) $email
        ));
    }
}
