<?php

namespace AppBundle\Command;

use AppBundle\Traits\RedisLockTrait;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * DemoCommand.
 */
class DemoCommand extends ContainerAwareCommand
{
    use RedisLockTrait;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('demo:lock')
            ->setDescription('Redis lock demo')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->checkIfLocked();
        } catch (\RuntimeException $e) {
            $output->writeln(sprintf('<error>Task already executed. Execution cancelled..</error>'));
            return;
        }

        // your own code
        $output->writeln('<comment>Hello world</comment>');
    }
}
