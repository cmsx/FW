<?php

namespace CMSx;

abstract class X
{
  protected static $db;
  protected static $connections;

  public static function AddConnection($host, $user, $pass, $dbname, $charset, $name = null)
  {
    if (is_null($name)) {
      $name = 'default';
    }

    static::$connections[$name] = array(
      'host'    => $host,
      'user'    => $user,
      'pass'    => $pass,
      'dbname'  => $dbname,
      'charset' => $charset,
      'pdo'     => null,
    );
  }

  /** @return \PDO */
  public static function GetConnection($name = null)
  {
    if (is_null($name)) {
      $name = 'default';
    }

    if (isset(static::$connections[$name])) {
      $c = static::$connections[$name];
      if (is_null($c['pdo'])) {
        static::$connections[$name]['pdo'] = DB::PDO($c['host'], $c['user'], $c['pass'], $c['dbname'], $c['charset']);
      }

      return static::$connections[$name]['pdo'];
    }

    return false;
  }

  /** @return DB */
  public static function DB()
  {
    if (is_null(static::$db)) {
      static::$db = new DB(static::GetConnection(), PREFIX);
    }

    return static::$db;
  }
}