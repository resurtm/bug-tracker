<?php

declare(ticks = 1);

namespace AppBundle\Command\Worker;

use AppBundle\Entity\ContactMessage;
use Leezy\PheanstalkBundle\Proxy\PheanstalkProxy;
use Pheanstalk\Job;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;

class EmailWorkerCommand extends ContainerAwareCommand
{
    const EMAIL_TUBE = 'emails';

    /**
     * @var bool
     */
    private $mainLoopActive = false;

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('app:worker:email')
            ->setDescription('Application worker command which processes email jobs.')
            ->addOption('single-run', 's', InputOption::VALUE_NONE, 'Do not run command in infinite loop');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Email Jobs Worker',
            '=================',
        ]);

        /** @var PheanstalkProxy $pheanstalk */
        $pheanstalk = $this->getContainer()->get('leezy.pheanstalk.primary');
        /** @var Serializer $serializer */
        $serializer = $this->getContainer()->get('serializer');

        $this->mainLoopActive = true;

        pcntl_signal(SIGTERM, function () { $this->mainLoopActive = false; });
        pcntl_signal(SIGINT, function () { $this->mainLoopActive = false; });

        while ($this->mainLoopActive) {
            pcntl_signal_dispatch();

            /** @var Job $job */
            $job = $pheanstalk
                ->watch(self::EMAIL_TUBE)
                ->reserve(5);

            if (!($job instanceof Job)) {
                if ($input->getOption('single-run')) {
                    break;
                } else {
                    continue;
                }
            }

            // TODO: send emails here
            /** @var ContactMessage $entity */
            $entity = $serializer->deserialize($job->getData(), ContactMessage::class, 'json');
            $output->writeln($entity->getEmail());

            $pheanstalk->delete($job);
        }

        $output->writeln('Finished!');
    }
}
