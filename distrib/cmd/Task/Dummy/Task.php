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
      ->setDescription('Пример создания команды')
      ->addArgument('name', InputArgument::OPTIONAL, 'Имя', 'Пользователь')
      ->addOption('wow', 'w', InputOption::VALUE_NONE, 'Обрадоваться');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $str = sprintf(
      '<info>%s, %s!</info> <comment>Это</comment> <question>пример</question> <error>команды</error>.',
      $input->getOption('wow') ? 'Ух-ты' : 'Здравствуйте',
      $input->getArgument('name')
    );
    $output->writeln($str);
  }
}