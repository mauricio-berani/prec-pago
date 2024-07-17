<?php

namespace App\Services;

use Carbon\Carbon;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Message\AMQPMessage;

class BaseService
{
    public $connection;
    public $channel;
    public $ttl;
    public $queueName;

    public function __construct()
    {
        $this->ttl = config('transactions.ttl');
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_LOGIN'),
            env('RABBITMQ_PASSWORD')
        );
        $this->channel = $this->connection->channel();
        $this->queueName = config('transactions.queue_name');
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    protected function declareQueue()
    {
        $this->channel->queue_declare(
            $this->queueName,
            false,
            true,
            false,
            false,
            false,
            [
                'x-message-ttl' => ['I', $this->ttl * 1000],
            ]
        );
    }

    protected function publishTransaction(array $transaction)
    {
        $this->declareQueue();
        $msg = new AMQPMessage(
            json_encode($transaction),
            [
                'delivery_mode' => 2,
            ]
        );
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    protected function consumeTransactions()
    {
        $transactions = [];
        $now = Carbon::now();

        $callback = function ($msg) use (&$transactions, $now) {
            $transaction = json_decode($msg->body, true);
            $transactionTimestamp = Carbon::parse($transaction['timestamp']);
            $secondsDiff = $transactionTimestamp->diffInSeconds($now);

            if ($secondsDiff <= $this->ttl) {
                $transactions[] = $transaction;
            }
        };

        $this->channel->basic_consume($this->queueName, '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            try {
                $this->channel->wait(null, false, 1);
            } catch (AMQPTimeoutException $e) {
                break;
            }
        }

        return $transactions;
    }

    public function purgeQueue($queueName)
    {
        $this->channel->queue_purge($queueName);
    }
}
