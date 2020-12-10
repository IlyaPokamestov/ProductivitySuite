<?php

namespace IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\Criteria;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\CriteriaInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\OffsetPagination;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\PaginationInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CriteriaExtractor
 * @package IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework
 */
final class CriteriaExtractor
{
    /**
     * Build criteria based on default request parameters, like pagination.
     *
     * @param Request $request
     * @return CriteriaInterface
     */
    public static function fromRequest(Request $request): CriteriaInterface
    {
        $limit = $request->get('limit', PaginationInterface::LIMIT_DEFAULT);
        $offset = $request->get('offset', PaginationInterface::OFFSET_DEFAULT);

        Assert::integerish($limit, 'Limit should be a number!');
        Assert::integerish($offset, 'Offset should be a number!');

        $limit = intval($limit);
        $offset = intval($offset);

        return new Criteria(
            new OffsetPagination($offset, $limit)
        );
    }
}
