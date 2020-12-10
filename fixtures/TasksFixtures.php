<?php

namespace IlyaPokamestov\ProductivitySuite\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Email;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;

class TasksFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $consumerId = new ConsumerId('8086733f-7cdd-45ef-9cc7-05fc132fd993');
        $consumer = Consumer::register(
            $consumerId,
            new Name('IlyaPokamestov', 'Ilya', 'Pokamestov'),
            new Email('test@test.com')
        );

        $consumer->completeRegistration();

        $manager->persist($consumer);

        $ownerId = new OwnerId((string) $consumerId);
        $listId = new ListId('fd0e060c-2d15-4432-a463-12e5511fe6cc');
        $list = TaskList::create(
            $listId,
            'MyToDo',
            $ownerId
        );

        $manager->persist($list);

        $task = Task::create(
            new TaskId('0e4fea85-c28b-45dc-8df2-ca9d2c4110b3'),
            $listId,
            new Description('Task#0', ''),
            $ownerId
        );

        $manager->persist($task);

        for ($i = 1; $i < 20; $i++) {
            $task = Task::create(
                TaskId::generate(),
                $listId,
                new Description('Task#' . $i, ''),
                $ownerId
            );

            $manager->persist($task);
        }

        $manager->flush();
    }
}
