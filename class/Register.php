<?php
    class Register {

        private $data = '';
        public $errors = [];

        function __construct($data) {
            $this->data = $data;
        }

        function checkLogin() {
            preg_match('/[\s]/', $this->data['login'], $matches);
            $login_length = strlen($this->data['login']);

            if ($login_length < 6) {
                $this->errors['login'] = 'Минимум 6 символов';
            
                return false;
            }
            elseif ($login_length >= 6 && $matches[0]) {
                $this->errors['login'] = 'Не должно быть пробелов';
            
                return false;
            }

            return true;
        }

        function checkPass() {
            preg_match('/^(?=.*[A-Za-zА-Яа-я])(?=.*\d)[A-Za-zА-Яа-я\d]{6,}$/u', $this->data['pass'], $matches);
            if(!$matches[0]) {
                $this->errors['pass'] = 'Минимум 6 букв и цифр';

                return false;
            }

            return true;
        }

        function checkConfirmPass() {
            if($this->data['pass'] != $this->data['confirmPass']) {
                $this->errors['confirmPass'] = 'Пароли не совпадают';

                return false;
            }

            return true;
        }

        function checkEmail() {
            preg_match('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/', $this->data['email'], $matches);
            if (!$matches[0]) {
                $this->errors['email'] = 'Введите Email';

                return false;
            }

            return true;
        }

        function checkName() {
            preg_match('/[A-Za-zА-Яа-яЁё]{2,4}$/u', $this->data['name'], $matches);
            if (!$matches[0]) {
                $this->errors['name'] = 'Минимум две буквы';

                return false;
            }

            return true;
        }

    }
