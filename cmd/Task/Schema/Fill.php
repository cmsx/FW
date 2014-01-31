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

class Fill extends Command
{
  protected function configure()
  {
    $this
      ->setName('schema:fill')
      ->setDescription('Заполнение таблицы начальными данными')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема в неймспейсе Schema, из которой загружаются данные');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $schema = 'Schema\\' . $input->getArgument('schema');

    $output->writeln(HTML::Tag('info', 'Загружаем данные по схеме ' . $schema));

    if (!class_exists($schema)) {
      $output->writeln(HTML::Tag('error', sprintf('Схема %s не существует!', $schema)));

      return;
    }

    /** @var $s \CMSx\DB\Schema */
    $s = new $schema(X::DB());
    $s->fillTable();
    $output->writeln(HTML::Tag('info', 'Данные загружены'));
  }
}