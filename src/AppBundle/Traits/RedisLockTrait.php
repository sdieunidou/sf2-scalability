<?php

namespace AppBundle\Traits;

/**
 * RedisLockTrait.
 */
trait RedisLockTrait
{
    /**
     * Throw an \RuntimeException if the task was already executed by another server.
     */
    protected function checkIfLocked()
    {
        $redis = $this->getContainer()->get('snc_redis.default');
        $time = new \DateTime();

        $lockKey = sprintf('lock:%s:%s', $this->getName(), $time->format('Ymd-Hi'));
        $lockData = json_encode(['ts' => $time->getTimestamp()]);
        $lock = $redis->setnx($lockKey, $lockData);
        if (!$lock) {
            throw new \RuntimeException(sprintf('Command "%s" already started.', $this->getName()));
        }

        $redis->expire($lock, 300);
    }
}
