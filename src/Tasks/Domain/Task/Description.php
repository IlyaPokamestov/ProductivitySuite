<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Description
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task
 *
 * @ORM\Embeddable
 */
final class Description
{
    /**
     * @ORM\Column(type="string", length=150)
     *
     * @var string
     */
    private string $title;

    /**
     * @ORM\Column(type="text", length=1000)
     *
     * @var string
     */
    private string $note;

    /**
     * Description constructor.
     * @param string $title
     * @param string $note
     */
    public function __construct(string $title, string $note = '')
    {
        Assert::stringNotEmpty($title, 'Title can not be empty!');
        Assert::lessThan(mb_strlen($title), 151, 'Title is greater than 150 characters!');

        if ('' !== $note) {
            Assert::lessThan(mb_strlen($note), 1001, 'Note is greater than 1000 characters!');
        }

        $this->title = $title;
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }
}
