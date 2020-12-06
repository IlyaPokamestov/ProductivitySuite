<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindById;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\HandleTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param string $id
     * @return mixed
     */
    public function findById(string $id)
    {
        return $this->query(new FindById($id));
    }

    /**
     * @Route("/consumers", name="consumer.register", methods={"POST"})
     * @ParamConverter("registerConsumer", converter="fos_rest.request_body")
     *
     * @param RegisterConsumer $registerConsumer
     * @return \IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\Consumer
     */
    public function register(RegisterConsumer $registerConsumer)
    {
        $id = $this->command($registerConsumer);

        return $this->query(new FindById($id));
    }
}
