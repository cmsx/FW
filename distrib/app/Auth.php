<?php

use CMSx\Auth as BaseAuth;
use CMSx\Auth\User;

/**
 * Класс для авторизации
 * При необходимости можно заменить какой класс User используется
 *
 * @method User getUser() Получение текущего авторизованного пользователя
 */
class Auth extends BaseAuth
{
  /** Сохранение токена в БД */
  protected function createToken($user_id, $expire)
  {
    return User::CreateToken($user_id, $expire);
  }

  /** Удаление токена из БД */
  protected function deleteToken($token)
  {
    return User::DeleteToken($token);
  }

  /** Поиск юзера по логину и паролю */
  protected function findUser($user, $pass)
  {
    return User::FindForAuth($user, $pass);
  }

  /** Поиск юзера по токену */
  protected function findUserByToken($token)
  {
    return User::FindByToken($token);
  }
}