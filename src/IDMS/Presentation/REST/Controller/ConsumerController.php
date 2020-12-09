<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindConsumerById;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\ThrowValidationError;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryBusInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadModel as ReadConsumer;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ConsumerController
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Controller
 */
class ConsumerController
{
    /**
     * @Route("/consumers/{id}", name="consumer.show", methods={"GET"})
     *
     * @OA\Get(
     *     summary="View consumer"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of consumer",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns consumer by ID",
     *     @Model(type=ReadConsumer::class)
     * )
     * @OA\Response(
     *     response=404,
     *     description="Consumer not found",
     *     @Model(type=Error::class)
     * )
     * @OA\Tag(name="IDMS")
     *
     * @param string $id
     * @param QueryBusInterface $bus
     * @return ReadConsumer
     */
    public function findById(string $id, QueryBusInterface $bus)
    {
        return $bus->query(new FindConsumerById($id));
    }

    /**
     * @Route("/consumers", name="consumer.register", methods={"POST"})
     * @ParamConverter("registerConsumer", converter="fos_rest.request_body")
     *
     * @OA\Post(
     *     summary="Register consumer"
     * )
     * @OA\RequestBody(
     *     description="Consumer",
     *     required=true,
     *     @Model(type=RegisterConsumer::class)
     * )
     * @OA\Response(
     *     response=200,
     *     description="Consumer registered",
     *     @Model(type=ReadConsumer::class)
     * )
     * @OA\Tag(name="IDMS")
     *
     * @param RegisterConsumer $registerConsumer
     * @param ConstraintViolationListInterface $errors
     * @param CommandBusInterface $commandBus
     * @param QueryBusInterface $queryBus
     * @return ReadConsumer
     */
    public function register(
        RegisterConsumer $registerConsumer,
        ConstraintViolationListInterface $errors,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus
    ) {
        ThrowValidationError::fromConstraintViolation($errors);

        $id = $registerConsumer->getId();
        $commandBus->command($registerConsumer);

        return $queryBus->query(new FindConsumerById((string) $id));
    }
}
