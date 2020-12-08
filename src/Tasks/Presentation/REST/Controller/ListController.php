<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\Criteria;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList\RemoveList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\FindTasksBy;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindBy;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\HandleTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList;
use IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request\RequestBasedOwnershipPolicy;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList as ReadList;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class ListController
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller
 */
class ListController
{
    use HandleTrait;

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
     * @param RequestBasedOwnershipPolicy $policy
     * @return TaskList
     */
    public function listAll(Request $request, RequestBasedOwnershipPolicy $policy)
    {
        $criteria = Criteria::from($request)
            ->where(Criteria::expr()->eq('ownerId', $policy->getRequestOwnerId()));

        return $this->query(new FindBy($criteria));
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
            ->andWhere(Criteria::expr()->eq('completed', $completed))
        ;

        return $this->query(new FindTasksBy($criteria));
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
     *     @Model(type=CreateList::class)
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
     * @param CreateList $createList
     * @return TaskList
     */
    public function create(CreateList $createList)
    {
        $id = $this->command($createList);

        return $this->query(new FindById($id));
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
            $this->command(new RemoveList($id));
        } catch (EntityNotFoundException $exception) {
            //ignore as DELETE method is idempotent.
        }

        return new Response();
    }
}
