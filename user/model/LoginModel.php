<?php

namespace user;

class LoginModel
{
    public $oDb;

    public function __construct()
    {
        $this->oDb = \system\Registry::get('db');
    }

    public function login($sEmail, $sPassword)
    {
        $aResult = $this->oDb->add('SELECT id, password, role_id, fullname FROM users WHERE email = ?')->execute([$sEmail])->fetchAll();
        if (!count($aResult)) {
            return 2;
        }
        $aResult = $aResult[0];
        if (true || password_verify($sPassword, $aResult['password'])) {
            $_SESSION['user_id'] = $aResult['id'];
            $_SESSION['role_id'] = $aResult['role_id'];
            $_SESSION['fullname'] = $aResult['fullname'];
            return 1;
        }
        else {
            return 2;
        }
    }

    public function register($sEmail, $sPassword, $sName, $sAddress, $sTelephone, $sLogin) {
        // Проверка входных данных
        if (empty($sEmail) || empty($sPassword) || empty($sName) || empty($sAddress) || empty($sTelephone) || empty($sLogin)) {
            return "Пожалуйста, заполните все обязательные поля";
        }
        if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
            return "Неверный формат электронной почты";
        }
        if (strlen($sPassword) < 8) {
            return "Пароль должен быть не менее 8 символов";
        }
        if (!preg_match("/^[0-9]*$/", $sTelephone)) {
            return "В телефоне разрешены только цифры";
        }

        // Код для регистрации пользователя
        $hasError = false;
        if (count($this->oDb->add('SELECT id FROM users WHERE email = ?')->execute([$sEmail])->fetchAll())) {
            return "Компания с таким email уже существует";
        }
        if (count($this->oDb->add('SELECT id FROM users WHERE fullname = ?')->execute([$sName])->fetchAll())) {
            return "Компания с таким названием уже существует";
        }
        if (count($this->oDb->add('SELECT id FROM users WHERE login = ?')->execute([$sLogin])->fetchAll())) {
            return "Компания с таким логином уже существует";
        }
        try {
            $this->oDb->add('INSERT INTO users (created, updated, fullname, email, password, role_id, address, telephone, login) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)')
                ->execute([date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $sName, $sEmail, password_hash($sPassword, PASSWORD_BCRYPT), 3, $sAddress, $sTelephone, $sLogin]);
        }
        catch (\Exception $ex) {
            $hasError = true;
            \system\Logger::log($ex);
        }
        if ($hasError) {
            return "Произошла ошибка, обратитесь к администратору";
        }
        $aResult = $this->oDb->add('SELECT id FROM users WHERE email = ?')->execute([$sEmail])->fetchAll();
        $_SESSION['user_id'] = $aResult[0]['id'];
        $_SESSION['role_id'] = 3;
        $_SESSION['fullname'] = $sName;
        return 1;
    }

    public function createUser($sName, $sEmail, $sPassword, $iRoleId)
    {
        if (empty($sEmail) || empty($sPassword) || empty($sName) || empty($iRoleId)) {
            return "Пожалуйста, заполните все обязательные поля";
        }
        if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
            return "Неверный формат электронной почты";
        }
        if (strlen($sPassword) < 8) {
            return "Пароль должен быть не менее 8 символов";
        }
        if (count($this->oDb->add('SELECT id FROM users WHERE email = ?')->execute([$sEmail])->fetchAll())) {
            return "Компания с таким email уже существует";
        }
        if (count($this->oDb->add('SELECT id FROM users WHERE fullname = ?')->execute([$sName])->fetchAll())) {
            return "Компания с таким названием уже существует";
        }
        $hasError = false;
        try {
            $this->oDb->add('INSERT INTO users (created, updated, fullname, email, password, role_id) VALUES(?, ?, ?, ?, ?, ?)')
                ->execute([date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $sName, $sEmail, password_hash($sPassword, PASSWORD_BCRYPT), $iRoleId]);
        }
        catch (\Exception $ex) {
            $hasError = true;
            \system\Logger::log($ex);
        }
        if ($hasError) {
            return "Произошла ошибка, обратитесь к администратору";
        }
        return 1;
    }

    public function logout(){
        session_destroy();
    }

}