<?php

namespace Hummelflug\Result;

/**
 * Class Result
 * @package Hummelflug\Result
 */
class Result implements ResultInterface
{
    /**
     * @var integer
     */
    private $transactions;

    /**
     * @var float
     */
    private $elapsedTime;

    /**
     * @var float
     */
    private $dataTransferred;

    /**
     * @var float
     */
    private $responseTimeAverage;

    /**
     * @var float
     */
    private $concurrency;

    /**
     * @var integer
     */
    private $transactionsSuccessful;

    /**
     * @var integer
     */
    private $transactionsFailed;

    /**
     * @var float
     */
    private $longestTransaction;

    /**
     * @var float
     */
    private $shortestTransaction;

    /**
     * @var string
     */
    private $attackId;

    /**
     * @var string
     */
    private $instanceId;

    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var string
     */
    private $mark;

    /**
     * @var array
     */
    private $additionalData = [];

    /**
     * @param mixed $transactions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @param mixed $elapsedTime
     */
    public function setElapsedTime($elapsedTime)
    {
        $this->elapsedTime = $elapsedTime;
    }

    /**
     * @param mixed $dataTransferred
     */
    public function setDataTransferred($dataTransferred)
    {
        $this->dataTransferred = $dataTransferred;
    }

    /**
     * @param mixed $responseTimeAverage
     */
    public function setResponseTimeAverage($responseTimeAverage)
    {
        $this->responseTimeAverage = $responseTimeAverage;
    }

    /**
     * @param mixed $concurrency
     */
    public function setConcurrency($concurrency)
    {
        $this->concurrency = $concurrency;
    }

    /**
     * @param mixed $transactionsSuccessful
     */
    public function setTransactionsSuccessful($transactionsSuccessful)
    {
        $this->transactionsSuccessful = $transactionsSuccessful;
    }

    /**
     * @param mixed $longestTransaction
     */
    public function setLongestTransaction($longestTransaction)
    {
        $this->longestTransaction = $longestTransaction;
    }

    /**
     * @param mixed $shortestTransaction
     */
    public function setShortestTransaction($shortestTransaction)
    {
        $this->shortestTransaction = $shortestTransaction;
    }

    /**
     * @return integer
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @return float
     */
    public function getElapsedTime()
    {
        return $this->elapsedTime;
    }

    /**
     * @return float
     */
    public function getDataTransferred()
    {
        return $this->dataTransferred;
    }

    /**
     * @return float
     */
    public function getResponseTimeAverage()
    {
        return $this->responseTimeAverage;
    }

    /**
     * @return float
     */
    public function getConcurrency()
    {
        return $this->concurrency;
    }

    /**
     * @return integer
     */
    public function getTransactionsSuccessful()
    {
        return $this->transactionsSuccessful;
    }

    /**
     * @return integer
     */
    public function getTransactionsFailed()
    {
        return $this->transactionsFailed;
    }

    /**
     * @return float
     */
    public function getLongestTransaction()
    {
        return $this->longestTransaction;
    }

    /**
     * @return float
     */
    public function getShortestTransaction()
    {
        return $this->shortestTransaction;
    }

    /**
     * @return float
     */
    public function getAvailability()
    {
        if ($this->transactionsSuccessful + $this->transactionsFailed > 0) {
            return $this->transactionsSuccessful / ($this->transactionsSuccessful + $this->transactionsFailed);
        }

        return 0;
    }

    /**
     * @param int $transactionsFailed
     */
    public function setTransactionsFailed($transactionsFailed)
    {
        $this->transactionsFailed = $transactionsFailed;
    }

    /**
     * @return string
     */
    public function getAttackId()
    {
        return $this->attackId;
    }

    /**
     * @param string $attackId
     */
    public function setAttackId($attackId)
    {
        $this->attackId = $attackId;
    }

    /**
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * @param string $instanceId
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return float
     */
    public function getThroughput()
    {
        if ($this->getElapsedTime() > 0) {
            return $this->getDataTransferred() / $this->getElapsedTime();
        }

        return 0;
    }

    /**
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param string $mark
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getAdditionalData($name)
    {
        return $this->additionalData[$name];
    }

    /**
     * @param string $additionalData
     */
    public function setAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;
    }

    /**
     * @return bool
     */
    public function hasAdditionalData()
    {
        return !empty($this->additionalData);
    }

    /**
     * @return array
     */
    public function getAdditionalDataKeys()
    {
        return array_keys($this->additionalData);
    }

    /**
     * @return array
     */
    public function getAdditionalDataValues()
    {
        return array_values($this->additionalData);
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'get') === 0) {
            $property = str_replace('get', '', $name);

            if (array_key_exists($property, $this->additionalData)) {
                return $this->getAdditionalData($property);
            }
        }

        throw new \Exception('Method ' . $name . ' does not exist.');
    }
}