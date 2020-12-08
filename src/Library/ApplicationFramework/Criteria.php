<?php

namespace IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework;

use Doctrine\Common\Collections\Criteria as BaseCriteria;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Criteria
 * @package IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework
 *
 * TODO: Criteria should be generic and do not depend on Doctrine somehow.
 * TODO: Inherited to save time to not implement criteria builder at the moment.
 */
final class Criteria extends BaseCriteria
{
    private const LIMIT_DEFAULT = 20;
    private const LIMIT_MAX = 20;
    private const OFFSET_DEFAULT = 0;

    /**
     * Build criteria based on default request parameters, like pagination.
     *
     * TODO: Move pagination logic to a separate class.
     *
     * @param Request $request
     * @return static
     */
    public static function from(Request $request): self
    {
        $limit = $request->get('limit', self::LIMIT_DEFAULT);
        $offset = $request->get('offset', self::OFFSET_DEFAULT);

        Assert::integerish($limit, 'Limit should be a number!');
        Assert::integerish($offset, 'Offset should be a number!');

        $limit = intval($limit);
        $offset = intval($offset);

        Assert::greaterThanEq($limit, 0);
        Assert::greaterThanEq($offset, 0);
        Assert::lessThanEq($limit, self::LIMIT_MAX);

        $criteria = new static();
        $criteria->setFirstResult($offset)
            ->setMaxResults($offset + $limit);

        return $criteria;
    }
}
