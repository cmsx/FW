<?php

namespace Task\Schema;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CMSx\HTML;
use CMSx\X;

class Model extends Command
{
  protected function configure()
  {
    $this
      ->setName('schema:model')
      ->setDescription('Создание объекта Item на основе схемы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема, по которой генерируется модель')
      ->addArgument('class', InputArgument::REQUIRED, 'Имя класса')
      ->addOption('force', 'f', InputOption::VALUE_NONE, 'Если файл существует - перезаписать');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $schema = $input->getArgument('schema');
    $class  = $input->getArgument('class');
    $force  = $input->getOption('force');
    $output->writeln(HTML::Tag('info', sprintf('Генерирую класс модели %s по схеме %s...', $class, $schema)));

    //Определяем неймспейс
    $ns        = false;
    $path      = DIR_APP;
    $a         = explode('\\', trim(str_replace('/', '\\', $class), '\\'));
    $classname = array_pop($a);
    if (count($a)) {
      $ns = join('\\', $a);
      $path .= DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, $a);
    }

    if (!class_exists($schema)) {
      $output->writeln(HTML::Tag('error', sprintf('Схема %s не существует!', $schema)));

      return;
    }

    /** @var $s \CMSx\DB\Schema */
    $s    = new $schema(X::DB());
    $code = $s->buildModel($classname, $ns);

    if (!is_dir($path)) {
      mkdir($path, 0750, true);
    }

    $file = $path . DIRECTORY_SEPARATOR . $classname . '.php';
    if (!is_file($file) || $force) {
      file_put_contents($file, $code);

      $output->writeln(HTML::Tag('info', sprintf('Файл модели %s создан: %s', $classname, $file)));
    } else {
      $output->writeln(
        HTML::Tag('error', sprintf('Файл модели %s уже существует! Используйте опцию -f для перезаписи', $file))
      );
    }
  }
}