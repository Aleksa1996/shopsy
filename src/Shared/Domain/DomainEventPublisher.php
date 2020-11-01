<?php

namespace App\Shared\Domain;

class DomainEventPublisher
{
    /**
     * @var DomainEventSubscriber[]
     */
    private $subscribers;

    /**
     * @var DomainEventPublisher
     */
    private static $instance = null;

    /**
     * @var int
     */
    private $id = 0;

    /**
     * DomainEventPublisher constructor.
     */
    private function __construct()
    {
        $this->subscribers = [];
    }

    /**
     * Get instance
     *
     * @return DomainEventPublisher|null
     */
    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * Clone magic method
     */
    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }

    /**
     * Subscribe to event
     *
     * @param $aDomainEventSubscriber
     *
     * @return int
     */
    public function subscribe($aDomainEventSubscriber)
    {
        $id = $this->id;
        $this->subscribers[$id] = $aDomainEventSubscriber;
        $this->id++;

        return $id;
    }

    /**
     * Get subscriber by id
     *
     * @param $id
     *
     * @return DomainEventSubscriber|mixed|null
     */
    public function byId($id)
    {
        return isset($this->subscribers[$id]) ? $this->subscribers[$id] : null;
    }

    /**
     * Unsubscribe by id
     *
     * @param $id
     */
    public function unsubscribe($id)
    {
        unset($this->subscribers[$id]);
    }

    /**
     * Publish events
     *
     * @param DomainEvent $aDomainEvent
     */
    public function publish(DomainEvent $aDomainEvent)
    {
        foreach ($this->subscribers as $aSubscriber) {
            if ($aSubscriber->isSubscribedTo($aDomainEvent)) {
                $aSubscriber->handle($aDomainEvent);
            }
        }
    }
}
