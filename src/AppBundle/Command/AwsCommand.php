<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AwsCommand
 */
class AwsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:aws:upload')
            ->setDescription('Upload a file to AWS S3')
            ->addArgument('path', InputArgument::REQUIRED, 'File path');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $storageManager = $this->getContainer()->get('app.file_storage');

        try {
            $url = $storageManager->upload($input->getArgument('path'));
            $output->writeln(sprintf('<info>File uploaded: %s</info>', $url));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            return -1;
        }
    }
}
