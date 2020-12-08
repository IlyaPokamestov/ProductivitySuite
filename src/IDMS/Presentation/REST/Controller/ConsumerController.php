<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindById;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\HandleTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\Consumer as ReadConsumer;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class ConsumerController
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Controller
 */
class ConsumerController
{
    use HandleTrait;

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
        return $this->query(new FindById($id));
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
     * @return ReadConsumer
     */
    public function register(RegisterConsumer $registerConsumer)
    {
        $id = $this->command($registerConsumer);

        return $this->query(new FindById($id));
    }
}
