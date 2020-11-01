<?php


namespace App\Shared\Application\Service;


class TransactionalApplicationService
{
    /**
     * @var TransactionalSession
     */
    private $session;

    /**
     * @param TransactionalSession $session
     */
    public function __construct(TransactionalSession $session)
    {
        $this->session = $session;
    }

    /**
     * @param $operation
     *
     * @return mixed
     */
    public function execute($operation)
    {
        return $this->session->executeAtomically($operation);
    }


}