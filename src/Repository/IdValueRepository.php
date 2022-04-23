<?php

namespace Notification\Repository;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\HydratorInterface;

class IdValueRepository implements IdValueRepositoryInterface
{
    /**
     * Account Table name
     *
     * @var string
     */
    private string $tableAccount = 'notification_id_value';

    /**
     * @var AdapterInterface
     */
    private AdapterInterface $db;

    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator
    ) {
        $this->db                  = $db;
        $this->hydrator            = $hydrator;
    }
}