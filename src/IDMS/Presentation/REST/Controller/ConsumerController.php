<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindConsumerById;
use IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Request\RegistrationRequest;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\ThrowValidationError;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging\CqrsControllerTrait;
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
    use CqrsControllerTrait;

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
     * @return ReadConsumer
     */
    public function findById(string $id)
    {
        return $this->queryBus->query(new FindConsumerById($id));
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
     *     @Model(type=RegistrationRequest::class)
     * )
     * @OA\Response(
     *     response=200,
     *     description="Consumer registered",
     *     @Model(type=ReadConsumer::class)
     * )
     * @OA\Tag(name="IDMS")
     *
     * @param RegistrationRequest $registerConsumer
     * @param ConstraintViolationListInterface $errors
     * @return ReadConsumer
     */
    public function register(RegistrationRequest $registerConsumer, ConstraintViolationListInterface $errors)
    {
        ThrowValidationError::fromConstraintViolation($errors);

        $command = new RegisterConsumer(
            $registerConsumer->getUsername(),
            $registerConsumer->getFirstName(),
            $registerConsumer->getLastName(),
            $registerConsumer->getEmail(),
        );

        $this->commandBus->command($command);

        return $this->queryBus->query(new FindConsumerById((string) $command->getId()));
    }
}
