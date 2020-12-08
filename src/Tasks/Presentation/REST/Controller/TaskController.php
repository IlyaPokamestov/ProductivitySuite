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
use IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request\CompleteTaskRequest;
use IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request\MoveTaskRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class TaskController
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller
 */
class TaskController
{
    use HandleTrait;

    /**
     * @Route("/tasks", name="task.create", methods={"POST"})
     * @ParamConverter("createTask", converter="fos_rest.request_body")
     *
     * @OA\Post(
     *     summary="Create task"
     * )
     * @OA\RequestBody(
     *     description="Task",
     *     required=true,
     *     @Model(type=CreateTask::class)
     * )
     * @OA\Response(
     *     response=200,
     *     description="Task created",
     *     @Model(type=Task::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - Task")
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
     * @OA\Patch(
     *     summary="Complete task"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of task",
     *     @OA\Schema(type="string")
     * )
     * @OA\RequestBody(
     *     description="Complete Request",
     *     required=true,
     *     @Model(type=CompleteTaskRequest::class)
     * )
     * @OA\Response(
     *     response=200,
     *     description="Task completed",
     *     @Model(type=Task::class)
     * )
     * @OA\Response(
     *     response=404,
     *     description="Task not found",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Consumer is not allowed to view this task",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - Task")
     *
     * @param string $id
     * @param CompleteTaskRequest $patchRequest
     * @return Task
     */
    public function complete(string $id, CompleteTaskRequest $patchRequest)
    {
        if ($patchRequest->isCompleted()) {
            $this->command(new CompleteTask($id));
        }

        return $this->query(new FindById($id));
    }

    /**
     * @Route("/tasks/{id}", name="task.remove", methods={"DELETE"})
     *
     * @OA\Delete(
     *     summary="Remove task"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of task",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Task removed",
     *     @Model(type=Task::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Consumer is not allowed to view this task",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - Task")
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
     * @OA\Put(
     *     summary="Move to another list"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of task",
     *     @OA\Schema(type="string")
     * )
     * @OA\RequestBody(
     *     description="Move Request",
     *     required=true,
     *     @Model(type=MoveTaskRequest::class)
     * )
     * @OA\Response(
     *     response=200,
     *     description="Task moved",
     *     @Model(type=MoveTaskRequest::class)
     * )
     * @OA\Response(
     *     response=404,
     *     description="Task not found",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Consumer is not allowed to view this task",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - Task")
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
