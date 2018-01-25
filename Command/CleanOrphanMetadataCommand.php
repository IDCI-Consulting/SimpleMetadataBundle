<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: MIT
 */

namespace IDCI\Bundle\SimpleMetadataBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\DoctrineCommandHelper;

class CleanOrphanMetadataCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('idci:metadata:clean-orphan')
            ->setDescription('Clean orphans metadata without associated Object')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'if present the orphan metadatas will be removed')
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command', 'default')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command.

To list all orphan metadata:

<info>php app/console %command.name%</info>

To clean the orphan metadata:

<info>php app/console %command.name% --force|-f</info>

EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeStart = microtime(true);
        $count = 0;
        $rcount = 0;

        DoctrineCommandHelper::setApplicationEntityManager(
            $this->getApplication(),
            $input->getOption('em')
        );
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        $metadatas = $entityManager->getRepository('IDCISimpleMetadataBundle:Metadata')->findAll();

        $output->writeln(sprintf('<info>Beginning of the Metadata Cleaning</info>'));

        foreach ($metadatas as $metadata) {
            $object = null;
            try {
                $object = $entityManager
                    ->getRepository($metadata->getObjectClassName())
                    ->findOneBy(array(
                        'id' => $metadata->getObjectId(),
                    ))
                ;
            } catch (\Exception $e) {
                $object = null;
            }

            if (null === $object) {
                $output->writeln(sprintf(
                    '<info>Metadata %d has no associated object [%s, %d]</info>',
                    $metadata->getId(),
                    $metadata->getObjectClassName(),
                    $metadata->getObjectId()
                ));

                if ($input->getOption('force')) {
                    $entityManager->remove($metadata);
                    $entityManager->flush();
                    ++$rcount;
                }
            }
            ++$count;
        }

        $timeEnd = microtime(true);
        $time = $timeEnd - $timeStart;
        $output->writeln(sprintf(
            '<comment>End of the Metadata Cleaning [%d sec] %d metadatas processed, %d metadatas removed, %d metadatas untouched</comment>',
            $time,
            $count,
            $rcount,
            ($count - $rcount)
        ));
    }
}
