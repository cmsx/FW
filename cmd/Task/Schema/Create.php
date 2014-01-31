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

class Create extends Command
{
  protected function configure()
  {
    $this
      ->setName('schema:create')
      ->setDescription('Создание таблицы на основе схемы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема в неймспейсе Schema, по которой генерируется модель')
      ->addOption('drop', 'd', InputOption::VALUE_NONE, 'DROP таблицы, если она существует')
      ->addOption('skip-content', 's', InputOption::VALUE_NONE, 'Не загружать начальные данные');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $schema = 'Schema\\' . $input->getArgument('schema');
    $drop = (bool)$input->getOption('drop');
    $skip = $input->getOption('skip-content');

    $output->writeln(HTML::Tag('info', 'Создаем таблицу по схеме ' . $schema));

    if (!class_exists($schema)) {
      $output->writeln(HTML::Tag('error', sprintf('Схема %s не существует!', $schema)));

      return;
    }

    /** @var $s \CMSx\DB\Schema */
    $s = new $schema(X::DB());
    $s->createTable($drop);
    $output->writeln(HTML::Tag('info', sprintf('Таблица %s%s создана', X::DB()->getPrefix(), $s->getTable())));

    if (!$skip) {
      $s->fillTable();
      $output->writeln(HTML::Tag('info', 'Начальные данные загружены'));
    }
  }
}