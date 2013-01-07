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
      ->setDescription('Разворачивание фреймворка из папки distrib')
      ->addArgument('path', InputArgument::OPTIONAL, 'Полный путь', false)
      ->addOption('force', 'f', InputOption::VALUE_OPTIONAL, 'Заменять файлы, даже если они существуют', false);
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $pwd   = $input->getArgument('path') ? : '.';
    $force = $input->hasOption('force');
    $this->recursiveCopy($pwd . DIRECTORY_SEPARATOR . 'distrib', $pwd, $output, $force);
  }

  protected function recursiveCopy($source, $dest, OutputInterface $output, $force)
  {
    $path = rtrim($source, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '{,.}*';
    $dest = rtrim($dest, DIRECTORY_SEPARATOR);
    $arr  = glob($path, GLOB_BRACE);
    foreach ($arr as $f) {
      $a  = explode(DIRECTORY_SEPARATOR, $f);
      $fn = array_pop($a);
      $p = $dest . DIRECTORY_SEPARATOR . $fn;

      if ($fn == '.' || $fn == '..') {
        continue;
      }

      if (is_dir($f)) {
        if (!is_dir($p)) {
          $output->writeln('Creating directory: "' . $p . '"');
          mkdir($p, 0750, true);
        }
        $output->writeln(HTML::Tag('info', 'Copying files from "' . $f . '"'));
        $this->recursiveCopy($f, $p, $output, $force);
      } else {
        if (!$force && is_file($p)) {
          $output->writeln(sprintf('File "%s" skipped', $f));
          continue;
        }

        $output->writeln(sprintf('File: "%s" to: "%s"', $f, $p));
        copy($f, $p);
      }
    }
  }
}