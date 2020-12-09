<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\ThrowValidationError;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization\AuthorizationAwareInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization\AuthorizationAwareTrait;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging\CqrsControllerTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\MoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CompleteTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindTaskById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request\CompleteTaskRequest;
use IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request\CreateTaskRequest;
use IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request\MoveTaskRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class TaskController
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller
 */
class TaskController implements AuthorizationAwareInterface
{
    use CqrsControllerTrait;
    use AuthorizationAwareTrait;

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
     *     @Model(type=TaskReadModel::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - Task")
     *
     * @param CreateTaskRequest $createTask
     * @param ConstraintViolationListInterface $errors
     * @return TaskReadModel
     */
    public function create(CreateTaskRequest $createTask, ConstraintViolationListInterface $errors)
    {
        ThrowValidationError::fromConstraintViolation($errors);

        $command = new CreateTask(
            $createTask->getTitle(),
            $createTask->getNote(),
            $createTask->getListId(),
            $this->authorizationContext->getRequesterId()
        );
        $this->commandBus->command($command);

        return $this->queryBus->query(new FindTaskById((string) $command->getId()));
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
     *     @Model(type=TaskReadModel::class)
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
     * @param ConstraintViolationListInterface $errors
     * @return TaskReadModel
     */
    public function complete(string $id, CompleteTaskRequest $patchRequest, ConstraintViolationListInterface $errors)
    {
        ThrowValidationError::fromConstraintViolation($errors);

        if ($patchRequest->isCompleted()) {
            $this->commandBus->command(new CompleteTask($id));
        }

        return $this->queryBus->query(new FindTaskById($id));
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
     *     @Model(type=TaskReadModel::class)
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
            $this->commandBus->command(new RemoveTask($id));
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
     * @param ConstraintViolationListInterface $errors
     * @return MoveTaskRequest
     */
    public function move(string $id, MoveTaskRequest $moveTask, ConstraintViolationListInterface $errors)
    {
        ThrowValidationError::fromConstraintViolation($errors);

        $this->commandBus->command(new MoveTask($id, $moveTask->getListId()));

        return $moveTask;
    }
}
