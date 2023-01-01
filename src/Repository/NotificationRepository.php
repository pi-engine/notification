<?php

namespace Notification\Repository;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Insert;
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

    public function getNotificationList($params,$account)
    {

        $where = ['receiver_id' => $params['user_id']];

        $sql = new Sql($this->db);
        $select = $sql->select($this->tableNotification)->where($where)->order($params['order'])->offset($params['offset'])->limit($params['limit']);
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
                        "id" => $notification->getPlatformId()
                    ]
                )
            );

            /// add target object to list from target id
            $notification->setTarget(
                $this->getIdValue(
                    [
                        "id" => $notification->getTargetId()
                    ]
                )
            );

            /// add message type object to list from type id
            $notification->setMessageType(
                $this->getIdValue(
                    [
                        "id" => $notification->getType()
                    ]
                )
            );
        }

        return $resultSet->toArray();
    }

    public function getNotification($params)
    {

        $where = ['id' => $params['id']];

        $sql = new Sql($this->db);
        $select = $sql->select($this->tableNotification)->where($where);
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
                        "id" => $notification->getPlatformId()
                    ]
                )
            );

            /// add target object to list from target id
            $notification->setTarget(
                $this->getIdValue(
                    [
                        "id" => $notification->getTargetId()
                    ]
                )
            );

            /// add message type object to list from type id
            $notification->setMessageType(
                $this->getIdValue(
                    [
                        "id" => $notification->getType()
                    ]
                )
            );
        }

        /// TODO : return a object
        return $resultSet->toArray()[0];
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
        return $resultSet->toArray()[0] ?? null;
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
        return $resultSet->toArray()[0] ?? null;
    }

    /**
     * @param array $params
     *
     * @return notification
     */
    public function store($params, $account)
    {
        $params["message_id"] = $this->storeMessage($params)["id"];
        $notificationId = $this->storeNotification($params);
        return $this->getNotification(["id"=>$notificationId]);
    }

    /**
     * @param array $params
     *
     * @return int $notificationId
     */
    public function storeNotification($params, $account)
    {
        $data = array();
        $data["id"] =null;
        $data["message_id"] =$params["message_id"]??0;
        $data["sender_id"] =$params["sender_id"]??0;
        $data["receiver_id"] =$params["receiver_id"]??0;
        $data["platform_id"] =$params["platform_id"]??0;
        $data["target_id"] =$params["target_id"]??0;
        $data["type"] =$params["type"]??0;
        $data["status"] =$params["status"];
        $data["time_create"] =time();
        $insert = new Insert($this->tableNotification);
        $insert->values($data);

        $sql       = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result    = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during blog post insert operation'
            );
        }

        return $result->getGeneratedValue();
    }

    /**
     * @param array $params
     *
     * @return int $messageId
     */
    public function storeMessage($params, $account)
    {
        $data = array();
        $data["id"] =null;
        $data["sender_id"] =$account["id"];
        $data["title"] =$params["title"]??'';
        $data["text"] =$params["text"]??'';
        $data["image"] =$params["image"]??'';
        $data["link"] =$params["link"]??'';
        $data["time_create"] =time();
        $insert = new Insert($this->tableMessage);
        $insert->values($data);

        $sql       = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result    = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during blog post insert operation'
            );
        }


        $message = $this->getMessage(["id"=>$result->getGeneratedValue()]);

        return $message;
    }
}