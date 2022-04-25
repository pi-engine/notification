<?php

namespace Notification\Repository;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Sql;
use Laminas\Hydrator\HydratorInterface;
use Notification\Model\Notification\Notification;
use RuntimeException;
use InvalidArgumentException;


class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * Notification Table name
     *
     * @var string
     */
    private string $tableNotification = 'notification_noti';

    /**
     * @var AdapterInterface
     */
    private AdapterInterface $db;


    /**
     * @var Notification
     */
    private Notification $notificationPrototype;

    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    public function __construct(
        AdapterInterface  $db,
        HydratorInterface $hydrator,
        Notification      $notificationPrototype
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->notificationPrototype = $notificationPrototype;
    }

    public function getList($params, array $account)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select($this->tableNotification);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving blog post with identifier "%s"; unknown database error.',
                $params
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->notificationPrototype);
        $resultSet->initialize($result);
        return $resultSet->toArray();
    }
}