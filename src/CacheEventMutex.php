<?php

namespace omnilight\scheduling;

use Yii;
use yii\base\Component;
use yii\caching\Cache;
use yii\caching\FileCache;

class CacheEventMutex extends Component implements EventMutex
{
    /**
     * The cache repository implementation.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->cache = Yii::$app->has('cache') ? Yii::$app->get('cache') : new FileCache();
    }

    /**
     * Attempt to obtain an event mutex for the given event.
     *
     * @param Event $event
     * @return bool
     */
    public function create(Event $event)
    {
        return $this->cache->set(
            $event->mutexName(), true, $event->getExpiresAt() * 60
        );
    }

    /**
     * Determine if an event mutex exists for the given event.
     *
     * @param $event
     * @return bool
     */
    public function exists(Event $event)
    {
        return $this->cache->exists($event->mutexName());
    }

    /**
     * Clear the event mutex for the given event.
     *
     * @param $event
     * @return void
     */
    public function forget(Event $event)
    {
        $this->cache->delete($event->mutexName());
    }

    public function getCache()
    {
        return $this->cache;
    }
}
