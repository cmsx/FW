<?php

namespace Task\Dummy;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Task extends Command
{
  protected function configure()
  {
    $this
      ->setName('dummy:task')
      ->setDescription('Пример создания команды');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln('Я ничего не умею.');
  }
}