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
     * @ORM\Embedded(class = "Status")
     *
     * @var Status
     */
    private Status $status;

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
        return new static($id, $name, $email, Status::registrationInProgress());
    }

    /**
     * Consumer constructor.
     * @param ConsumerId $id
     * @param Name $name
     * @param Email $email
     * @param Status $status
     */
    final public function __construct(ConsumerId $id, Name $name, Email $email, Status $status)
    {
        $this->name = $name;
        $this->id = $id;
        $this->email = $email;
        $this->status = $status;

        $this->record(new RegistrationInitiated(
            (string) $this->id,
            $this->name->getUsername(),
            $this->name->getFirstName(),
            $this->name->getLastName(),
            (string) $this->email,
            (string) $this->status
        ));
    }

    /**
     * Complete registration after all the components setup.
     */
    public function completeRegistration(): void
    {
        $this->status = Status::active();

        $this->record(new RegistrationCompleted(
            (string) $this->id,
            (string) $this->status
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

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }
}
