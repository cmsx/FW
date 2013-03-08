<?php

namespace Task\Schema;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CMSx\HTML;
use CMSx\DB;
use CMSx\X;

class Update extends Command
{
  protected function configure()
  {
    $this
      ->setName('schema:update')
      ->setDescription('Обновление структуры таблицы на основе схемы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема, по которой генерируется модель');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $schema = $input->getArgument('schema');

    $output->writeln(HTML::Tag('info', 'Обновляем структуру таблицы по схеме ' . $schema));

    if (!class_exists($schema)) {
      $output->writeln(HTML::Tag('error', sprintf('Схема %s не существует!', $schema)));

      return;
    }

    /** @var $s \CMSx\DB\Schema */
    $s = new $schema(X::DB());
    $s->updateTable();
    $output->writeln(HTML::Tag('info', sprintf('Таблица %s%s обновлена', X::DB()->getPrefix(), $s->getTable())));
  }
}