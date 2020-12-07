<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Consumer
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 * @ORM\Entity()
 */
class Consumer extends AggregateRoot
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="consumer_id")
     *
     * @var ConsumerId
     */
    private ConsumerId $id;

    /**
     * @ORM\Embedded(class = "Name")
     *
     * @var Name
     */
    private Name $name;

    /**
     * @ORM\Embedded(class = "Email")
     *
     * @var Email
     */
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

    /**
     * @return ConsumerId
     */
    public function getId(): ConsumerId
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }
}
