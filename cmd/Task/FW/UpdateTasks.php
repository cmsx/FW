<?php

namespace Task\FW;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CMSx\HTML;

class UpdateTasks extends Command
{
  protected $tasks;

  protected function configure()
  {
    $this
      ->setName('fw:update-tasks')
      ->setDescription('Обновляет список доступных команд');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $output->writeln(HTML::Tag('info', 'Обновляю список команд приложения'));
    $this->collectTasks();
    $this->filterTasks();
    $this->saveList();
  }

  protected function saveList()
  {
    $f = fopen(CMD_LIST, 'w');
    fputs($f, "# Обновлено автоматически " . date('d.m.Y в H:i') . "\n");

    if (is_file(CMD_MANUAL)) {
      $manual = file(CMD_MANUAL, FILE_IGNORE_NEW_LINES);
      fputs($f, "\n# Команды из ручного списка:\n");
      foreach ($manual as $cmd) {
        if (!empty($cmd) && '#' != substr($cmd, 0, 1)) {
          fputs($f, "$cmd\n");
        }
      }
    }

    fputs($f, "\n# Команды текущего приложения:\n");
    foreach ($this->tasks as $cmd) {
      fputs($f, "$cmd\n");
    }
    fclose($f);
  }

  protected function filterTasks()
  {
    if (is_file(CMD_MANUAL)) {
      $out    = array();
      $ignore = file(CMD_MANUAL, FILE_IGNORE_NEW_LINES);
      foreach ($this->tasks as $str) {
        if (!in_array($str, $ignore)) {
          $out[] = $str;
        }
      }

      $this->tasks = $out;
    }
  }

  protected function collectTasks()
  {
    $n           = 'Task\\';
    $this->tasks = array();
    $arr         = glob(DIR_CMD . '/Task/*');
    foreach ($arr as $dir) {
      $a    = explode(DIRECTORY_SEPARATOR, $dir);
      $name = array_pop($a);
      if (is_dir($dir)) {
        $cmd_arr = glob($dir . DIRECTORY_SEPARATOR . '*');
        foreach ($cmd_arr as $file) {
          $a        = explode(DIRECTORY_SEPARATOR, $file);
          $a        = explode('.', array_pop($a));
          $cmd_name = array_shift($a);

          $this->tasks[] = $n . $name . '\\' . $cmd_name;
        }
      } else {
        $this->tasks[] = $n . $name;
      }
    }
  }
}