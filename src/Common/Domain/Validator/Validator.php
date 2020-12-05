<?php

namespace App\Common\Domain\Validator;



abstract class Validator
{
    /**
     * Validator Constructor
     *
     * @var ValidationNotificationHandler
     */
    protected $notificationHandler;

    /**
     * Validator Constructor
     *
     * @param ValidationNotificationHandler $notificationHandler
     */
    public function __construct(ValidationNotificationHandler $notificationHandler)
    {
        $this->setNotificationHandler($notificationHandler);
    }

    /**
     * Get the value of notificationHandler
     *
     * @return  ValidationNotificationHandler
     */
    public function getNotificationHandler()
    {
        return $this->notificationHandler;
    }

    /**
     * Set the value of notificationHandler
     *
     * @param  ValidationNotificationHandler  $notificationHandler
     *
     * @return  self
     */
    public function setNotificationHandler(ValidationNotificationHandler $notificationHandler)
    {
        $this->notificationHandler = $notificationHandler;

        return $this;
    }

    /**
     * @return void
     */
    public abstract function validate();
}
