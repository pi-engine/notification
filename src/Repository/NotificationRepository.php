<?php

namespace Notification\Repository;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Predicate\Expression;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Update;
use Laminas\Hydrator\HydratorInterface;
use Notification\Model\IdValue\IdValue;
use Notification\Model\Notification\Notification;
use Notification\Model\Message\Message;
use Notification\Model\Storage;
use RuntimeException;
use InvalidArgumentException;


class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * Notification Table name
     *
     * @var string
     */
    private string $tableNotification = 'notification_storage';

    /**
     * @var AdapterInterface
     */
    private AdapterInterface $db;

    /**
     * @var Storage
     */
    private Storage $storagePrototype;

    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        Storage $storagePrototype
    ) {
        $this->db               = $db;
        $this->hydrator         = $hydrator;
        $this->storagePrototype = $storagePrototype;
    }

    /**
     * @param array $params
     *
     * @return HydratingResultSet|array
     */
    public function getNotificationList(array $params = []): HydratingResultSet|array
    {
        $where = [];
        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $where['user_id'] = $params['user_id'];
        }
        if (isset($params['status']) && !empty($params['status'])) {
            $where['status'] = $params['status'];
        }
        if (isset($params['viewed']) && !empty($params['viewed'])) {
            $where['viewed'] = $params['viewed'];
        }
        if (isset($params['sent']) && !empty($params['sent'])) {
            $where['sent'] = $params['sent'];
        }
        if (isset($params['id']) && !empty($params['id'])) {
            $where['id'] = $params['id'];
        }


        $sql       = new Sql($this->db);
        $select    = $sql->select($this->tableNotification)->where($where)->order($params['order'])->offset($params['offset'])->limit($params['limit']);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->storagePrototype);
        $resultSet->initialize($result);

        return $resultSet;
    }

    /**
     * @param array $params
     *
     * @return int
     */
    public function getNotificationCount(array $params = []): int
    {
        // Set where
        $columns = ['count' => new Expression('count(*)')];
        $where   = [];

        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $where['user_id'] = $params['user_id'];
        }
        if (isset($params['status']) && !empty($params['status'])) {
            $where['status'] = $params['status'];
        }
        if (isset($params['viewed']) && !empty($params['viewed'])) {
            $where['viewed'] = $params['viewed'];
        }
        if (isset($params['sent']) && !empty($params['sent'])) {
            $where['sent'] = $params['sent'];
        }
        if (isset($params['id']) && !empty($params['id'])) {
            $where['id'] = $params['id'];
        }

        $sql       = new Sql($this->db);
        $select    = $sql->select($this->tableNotification)->columns($columns)->where($where);
        $statement = $sql->prepareStatementForSqlObject($select);
        $row       = $statement->execute()->current();

        return (int)$row['count'];
    }

    /**
     * @param array $params
     *
     * @return array|object
     */
    public function addNotification(array $params): object|array
    {
        $insert = new Insert($this->tableNotification);
        $insert->values($params);

        $sql       = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result    = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during blog post insert operation'
            );
        }
        $id = $result->getGeneratedValue();
        return $this->getNotification($id);
    }

    /**
     * @param string $parameter
     * @param string $type
     *
     * @return object|array
     */
    public function getNotification($parameter, $type = 'id'): object|array
    {
        $where = [$type => $parameter];

        $sql       = new Sql($this->db);
        $select    = $sql->select($this->tableNotification)->where($where);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new RuntimeException(
                sprintf(
                    'Failed retrieving blog post with identifier "%s"; unknown database error.',
                    $parameter
                )
            );
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->storagePrototype);
        $resultSet->initialize($result);
        $item = $resultSet->current();

        if (!$item) {
            return [];
        }

        return $item;
    }

    /**
     * @param array $params
     *
     * @return array|object
     */
    public function updateNotification(array $params): object|array
    {
        $update = new Update($this->tableNotification);
        $update->set($params);
        $update->where(['id' => $params['id']]);

        $sql       = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result    = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during update operation'
            );
        }
        return $this->getItem($params['id']);
    }

    /**
     * @param array $params
     *
     * @return void
     */
    public function deleteNotification(array $params): void
    {
        $delete = new Delete($this->tableNotification);
        $delete->set($params);
        $delete->where(['id' => $params['id']]);

        $sql       = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
    }
}