<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\Criteria;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\ThrowValidationError;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Authorization\AuthorizationContextInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization\AuthorizationAwareInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization\AuthorizationAwareTrait;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging\CqrsControllerTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindTasksBy;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindListBy;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindListById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskListReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request\CreateListRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskListReadModel as ReadList;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ListController
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller
 */
class ListController implements AuthorizationAwareInterface
{
    use CqrsControllerTrait;
    use AuthorizationAwareTrait;

    /**
     * @Route("/lists", name="list.list", methods={"GET"})
     *
     * @OA\Get(
     *     summary="All available lists"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns available lists",
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(ref=@Model(type=ReadList::class))
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Consumer is not allowed to view this list",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - List")
     *
     * @param Request $request
     * @return TaskListReadModel
     */
    public function listAll(Request $request)
    {
        $criteria = Criteria::from($request)
            ->where(Criteria::expr()->eq('ownerId', $this->authorizationContext->getRequesterId()));

        return $this->queryBus->query(new FindListBy($criteria));
    }

    /**
     * @Route("/lists/{id}/tasks", name="list.show", methods={"GET"})
     *
     * @OA\Get(
     *     summary="List of tasks"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of the list",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="completed",
     *     in="query",
     *     required=false,
     *     description="Show completed or active",
     *     @OA\Schema(type="bool")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns list by ID",
     *     @Model(type=ReadList::class)
     * )
     * @OA\Response(
     *     response=404,
     *     description="List not found",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Consumer is not allowed to view this list",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - List")
     *
     * @param string $id
     * @param Request $request
     * @return mixed
     */
    public function findTasksBy(string $id, Request $request)
    {
        $completed = (bool) $request->query->get('completed', null);

        $criteria = Criteria::from($request)
            ->where(Criteria::expr()->eq('listId', $id))
            ->andWhere(Criteria::expr()->eq('ownerId', $this->authorizationContext->getRequesterId()))
            ->andWhere(Criteria::expr()->eq('completed', $completed))
        ;

        return $this->queryBus->query(new FindTasksBy($criteria));
    }

    /**
     * @Route("/lists", name="list.create", methods={"POST"})
     * @ParamConverter("createList", converter="fos_rest.request_body")
     *
     * @OA\Post(
     *     summary="Create list"
     * )
     * @OA\RequestBody(
     *     description="List",
     *     required=true,
     *     @Model(type=CreateListRequest::class)
     * )
     * @OA\Response(
     *     response=200,
     *     description="List created",
     *     @Model(type=ReadList::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - List")
     *
     * @param CreateListRequest $createList
     * @param ConstraintViolationListInterface $errors
     * @return TaskListReadModel
     */
    public function create(CreateListRequest $createList, ConstraintViolationListInterface $errors)
    {
        ThrowValidationError::fromConstraintViolation($errors);

        $command = new CreateList(
            $createList->getName(),
            $this->authorizationContext->getRequesterId(),
        );
        $this->commandBus->command($command);

        return $this->queryBus->query(new FindListById((string) $command->getId()));
    }

    /**
     * @Route("/lists/{id}", name="list.remove", methods={"DELETE"})
     *
     * @OA\Delete(
     *     summary="Remove list"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of list",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="List removed",
     *     @Model(type=ReadList::class)
     * )
     * @OA\Response(
     *     response=401,
     *     description="Consumer is not authorized in the system",
     *     @Model(type=Error::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Consumer is not allowed to view this list",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="Tasks - List")
     *
     * @param string $id
     * @return Response
     */
    public function remove(string $id): Response
    {
        try {
            $this->commandBus->command(new RemoveList($id));
        } catch (EntityNotFoundException $exception) {
            //ignore as DELETE method is idempotent.
        }

        return new Response();
    }
}
