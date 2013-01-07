<?php

namespace Task\FW;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CMSx\HTML;

class Install extends Command
{
  protected function configure()
  {
    $this
      ->setName('fw:install')
      ->setDescription('Разворачивает дистрибутив приложения')
      ->addArgument('path', InputArgument::OPTIONAL, 'Полный путь', false)
      ->addOption('force', 'f', InputOption::VALUE_NONE, 'Заменять файлы, даже если они существуют')
      ->addOption('details', 'i', InputOption::VALUE_NONE, 'Отображать подробную информацию')
      ->addOption('dummy', 'd', InputOption::VALUE_NONE, 'Включить примеры тестов, классов и команд')
      ->addOption('fw-distrib', 'b', InputOption::VALUE_NONE, 'Использовать дистрибутив от FW');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln(HTML::Tag('info', 'Копирую файлы дистрибутива'));
    $pwd = $input->getArgument('path') ? : '.';
    $src = $input->getOption('fw-distrib')
      ? realpath(__DIR__ . '/../../../')
      : $pwd;
    $this->recursiveCopy($src . DIRECTORY_SEPARATOR . 'distrib', $pwd, $input, $output);
  }

  protected function recursiveCopy($source, $dest, InputInterface $input, OutputInterface $output)
  {
    $force   = $input->getOption('force');
    $details = $input->getOption('details');
    $dummy   = $input->getOption('dummy');

    $path = rtrim($source, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '{,.}*';
    $dest = rtrim($dest, DIRECTORY_SEPARATOR);
    $arr  = glob($path, GLOB_BRACE);
    foreach ($arr as $f) {
      $a  = explode(DIRECTORY_SEPARATOR, $f);
      $fn = array_pop($a);
      $p  = $dest . DIRECTORY_SEPARATOR . $fn;

      if ($fn == '.' || $fn == '..' || (!$dummy && false !== strpos(strtolower($f), 'dummy'))) {
        continue;
      }

      if (is_dir($f)) {
        if (!is_dir($p)) {
          if ($details) {
            $output->writeln('Создаю директорию: "' . $p . '"');
          }
          mkdir($p, 0750, true);
        }
        if ($details) {
          $output->writeln(HTML::Tag('info', 'Копирую файлы из "' . $f . '"'));
        }
        $this->recursiveCopy($f, $p, $input, $output);
      } else {
        if (!$force && is_file($p)) {
          if ($details) {
            $output->writeln(sprintf('Файл "%s" пропущен', $f));
          }
          continue;
        }

        if ($details) {
          $output->writeln(sprintf('"%s" => "%s"', $f, $p));
        }
        copy($f, $p);
      }
    }
  }
}