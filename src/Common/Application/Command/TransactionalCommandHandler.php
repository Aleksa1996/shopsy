<?php


namespace App\Common\Application\Command;


class TransactionalCommandHandler implements CommandHandler
{
    /**
     * @var TransactionalSession
     */
    private $session;

    /**
     * @var CommandHandler
     */
    private $commandHandler;

    /**
     * TransactionalCommandHandler constructor.
     *
     * @param CommandHandler $commandHandler
     * @param TransactionalSession $session
     */
    public function __construct(CommandHandler $commandHandler, TransactionalSession $session)
    {
        $this->session = $session;
        $this->commandHandler = $commandHandler;
    }

    /**
     * @param Command|null $command
     *
     * @return mixed
     */
    public function execute(Command $command = null)
    {
        if (empty($this->commandHandler)) {
            throw new \LogicException('A use case must be specified');
        }

        $operation = function () use ($command) {
            return $this->commandHandler->execute($command);
        };

        return $this->session->executeAtomically($operation);
    }
}