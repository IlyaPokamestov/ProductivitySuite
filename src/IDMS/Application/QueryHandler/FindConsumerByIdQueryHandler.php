<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\QueryHandler;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadModel;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindConsumerById;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryHandlerInterface;

/**
 * Class FindConsumerByIdQueryHandler
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\QueryHandler
 */
class FindConsumerByIdQueryHandler implements QueryHandlerInterface
{
    /** @var ConsumerReadRepository */
    public ConsumerReadRepository $consumerRepository;

    /**
     * ConsumerHandler constructor.
     * @param ConsumerReadRepository $consumerRepository
     */
    public function __construct(ConsumerReadRepository $consumerRepository)
    {
        $this->consumerRepository = $consumerRepository;
    }

    /**
     * @param FindConsumerById $findById
     * @return ConsumerReadModel
     */
    public function __invoke(FindConsumerById $findById): ConsumerReadModel
    {
        return $this->consumerRepository->findById($findById->getId());
    }
}
