<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\MoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\RemoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CompleteTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\FindById;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\HandleTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller
 */
class TaskController
{
    use HandleTrait;

    /**
     * @Route("/tasks/{id}", name="task.show", methods={"GET"})
     *
     * @param string $id
     * @return Task
     */
    public function findById(string $id)
    {
        return $this->query(new FindById($id));
    }

    /**
     * @Route("/tasks", name="task.create", methods={"POST"})
     * @ParamConverter("createTask", converter="fos_rest.request_body")
     *
     * @param CreateTask $createTask
     * @return Task
     */
    public function create(CreateTask $createTask)
    {
        $id = $this->command($createTask);

        return $this->query(new FindById($id));
    }

    /**
     * @Route("/tasks/{id}", name="task.update", methods={"PATCH"})
     * @ParamConverter("patchRequest", converter="fos_rest.request_body")
     *
     * @param string $id
     * @param CompleteTaskRequest $patchRequest
     * @return Task
     */
    public function update(string $id, CompleteTaskRequest $patchRequest)
    {
        if ($patchRequest->isCompleted()) {
            $this->command(new CompleteTask($id));
        }

        return $this->query(new FindById($id));
    }

    /**
     * @Route("/tasks/{id}", name="task.remove", methods={"DELETE"})
     *
     * @param string $id
     * @return JsonResponse
     */
    public function remove(string $id)
    {
        try {
            $this->command(new RemoveTask($id));
        } catch (EntityNotFoundException $exception) {
            //ignore
        }

        return new JsonResponse(null, 200);
    }

    /**
     * @Route("/tasks/{id}/list", name="task.move", methods={"PUT"})
     * @ParamConverter("moveTask", converter="fos_rest.request_body")
     *
     * @param string $id
     * @param MoveTaskRequest $moveTask
     * @return MoveTaskRequest
     */
    public function move(string $id, MoveTaskRequest $moveTask)
    {
        $this->command(new MoveTask($id, $moveTask->getListId()));

        return $moveTask;
    }
}
