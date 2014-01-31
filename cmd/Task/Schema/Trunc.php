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

class Trunc extends Command
{
  protected function configure()
  {
    $this
      ->setName('schema:trunc')
      ->setDescription('TRUNCATE таблицы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема в неймспейсе Schema, таблица которой стирается');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $schema = 'Schema\\' . $input->getArgument('schema');

    $output->writeln(HTML::Tag('info', 'Стираем данные таблицы из схемы ' . $schema));

    if (!class_exists($schema)) {
      $output->writeln(HTML::Tag('error', sprintf('Схема %s не существует!', $schema)));

      return;
    }

    /** @var $s \CMSx\DB\Schema */
    $s = new $schema(X::DB());
    X::DB()->truncate($s->getTable())->execute();
    $output->writeln(HTML::Tag('info', 'Таблица ' . $s->getTable() . ' очищена'));
  }
}