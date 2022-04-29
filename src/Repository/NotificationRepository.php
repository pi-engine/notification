<?php

namespace Notification\Repository;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Sql;
use Laminas\Hydrator\HydratorInterface;
use Notification\Model\IdValue\IdValue;
use Notification\Model\Notification\Notification;
use Notification\Model\Message\Message;
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
     * Message Table name
     *
     * @var string
     */
    private string $tableMessage = 'notification_message';

    /**
     * IdValue Table name
     *
     * @var string
     */
    private string $tableIdValue = 'notification_id_value';

    /**
     * @var AdapterInterface
     */
    private AdapterInterface $db;


    /**
     * @var Notification
     */
    private Notification $notificationPrototype;

    /**
     * @var Message
     */
    private Message $messagePrototype;

    /**
     * @var IdValue
     */
    private IdValue $idValuePrototype;

    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    public function __construct(
        AdapterInterface  $db,
        HydratorInterface $hydrator,
        Notification      $notificationPrototype,
        Message           $messagePrototype,
        IdValue           $idValuePrototype
    )
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->notificationPrototype = $notificationPrototype;
        $this->messagePrototype = $messagePrototype;
        $this->idValuePrototype = $idValuePrototype;
    }

    public function getList($params, array $account)
    {
        $sql = new Sql($this->db);
        $select = $sql->select($this->tableNotification);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving blog post with identifier "%s"; unknown database error.',
                $params
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->notificationPrototype);
        $resultSet->initialize($result);
        $resultSet->buffer();
        foreach ($resultSet as $notification) {

            /// add message object to list from message id
            $notification->setMessage(
                $this->getMessage(
                    [
                        "id" => $notification->getId()
                    ]
                )
            );

            /// add platform object to list from platform id
            $notification->setPlatform(
                $this->getIdValue(
                    [
                        "id" => $notification->getPlatformId(),
                        "type" => "platform"
                    ]
                )
            );

            /// add target object to list from target id
            $notification->setTarget(
                $this->getIdValue(
                    [
                        "id" => $notification->getTargetId()
                        , "type" => "target"
                    ]
                )
            );

            /// add message type object to list from type id
            $notification->setMessageType(
                $this->getIdValue(
                    [
                        "id" => $notification->getType(),
                        "type" => "type"
                    ]
                )
            );
        }

        return $resultSet->toArray();
    }


    /**
     * @param array $params
     *
     * @return Message
     */
    public function getMessage($params)
    {
        $sql = new Sql($this->db);

        $select = $sql->select($this->tableMessage)->where($params);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving message with id "%s"; unknown database error.',
                $params["id"]
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->messagePrototype);
        $resultSet->initialize($result);
        /// TODO: set return object
        return $resultSet->toArray()[0]??null;
    }

    /**
     * @param array $params
     *
     * @return IdValue ( object of id value type)
     */
    public function getIdValue($params)
    {
        $sql = new Sql($this->db);

        $select = $sql->select($this->tableIdValue)->where($params);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving type with id "%s"; unknown database error.',
                $params["id"]
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->idValuePrototype);
        $resultSet->initialize($result);
        /// TODO: set return object
        return $resultSet->toArray()[0]??null;
    }
}