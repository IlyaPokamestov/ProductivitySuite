<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindById;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\HandleTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListController
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller
 */
class ListController
{
    use HandleTrait;

    /**
     * @Route("/lists/{id}", name="list.show", methods={"GET"})
     *
     * @param string $id
     * @return TaskList
     */
    public function findById(string $id)
    {
        return $this->query(new FindById($id));
    }

    /**
     * @Route("/lists", name="list.create", methods={"POST"})
     * @ParamConverter("createList", converter="fos_rest.request_body")
     *
     * @param CreateList $createList
     * @return TaskList
     */
    public function create(CreateList $createList)
    {
        $id = $this->command($createList);

        return $this->query(new FindById($id));
    }
}