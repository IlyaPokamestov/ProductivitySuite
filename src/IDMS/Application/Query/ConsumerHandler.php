<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Query;

/**
 * Class ConsumerHandler
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Query
 */
class ConsumerHandler implements QueryHandlerInterface
{
    /** @var ConsumerRepository */
    public ConsumerRepository $consumerRepository;

    /**
     * ConsumerHandler constructor.
     * @param ConsumerRepository $consumerRepository
     */
    public function __construct(ConsumerRepository $consumerRepository)
    {
        $this->consumerRepository = $consumerRepository;
    }

    /**
     * @param FindById $findById
     * @return Consumer
     */
    public function __invoke(FindById $findById): Consumer
    {
        return $this->consumerRepository->findById($findById->getId());
    }
}
