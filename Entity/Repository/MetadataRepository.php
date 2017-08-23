<?php

/**
 * @author:  Brahim BOUKOUFALLAH <brahim.boukoufallah@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class MetadataRepository extends EntityRepository
{
    /**
     * Find by metadata query builder
     *
     * @param QueryBuilder $qb
     * @param string       $join
     * @param array        $metadata
     * @param string       $alias
     * @param string       $operator
     *
     * @return QueryBuilder
     */
    public static function findByMetadataQueryBuilder(
        QueryBuilder $qb,
        $join,
        array $metadata,
        $alias = 'metadata',
        $operator = 'eq'
    ) {
        $qb->join($join, $alias);

        foreach ($metadata as $key => $data) {
            $andX = $qb->expr()->andX();

            foreach ($data as $field => $value) {
                $itemOperator = $operator;

                if (is_array($value)) {
                    $value        = $value['value'];
                    $itemOperator = $value['operator'];
                }

                $parameterName = sprintf('%s_%s', $field, $key);
                $andX->add(call_user_func_array(
                    array($qb->expr(), $itemOperator),
                    array(
                        sprintf('%s.%s', $alias, $field),
                        sprintf(':%s', $parameterName)
                    )
                ));

                $qb->setParameter($parameterName, $value);
            }

            $qb->orWhere($andX);
        }

        return $qb;
    }
}
