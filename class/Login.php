<?php
    require_once 'User.php';
   
    class Login {

        public $errors = [];
        private $data = '';
        private $current_login;
        private $current_pass;
        private $user;

        function __construct($data) {
            $this->data = $data;
            $this->current_login = addslashes($this->data['login']);
            $this->current_pass = md5(addslashes($this->data['pass']) . 'SomethingSalt'); // static salt
            $this->user = new User($_SERVER['DOCUMENT_ROOT'] . '/db.json'); // if user exists in db
        }

        function checkLogin() {
            if (!$this->data['login']) {
                $this->errors['login'] = 'Enter login';
            }
            elseif (strlen($this->data['login']) < 6) {
                $this->errors['login'] = 'Min length 6 symbol';
            }
            elseif (!$this->user->read($this->data['login'])) {
                $this->errors['login'] = "User doesn't exist";
            }

            return true;
        }

        function checkPass() {
            preg_match('/^(?=.*[A-Za-zА-Яа-я])(?=.*\d)[A-Za-zА-Яа-я\d]{6,}$/u', $this->data['pass'], $matches);
            
            if (!$this->data['pass']) {
                $this->errors['pass'] = 'Enter password';

                return false;
            }
            elseif (!$matches[0]) {
                $this->errors['pass'] = 'Min length 6 numbers & letters';

                return false;
            }
            elseif ($this->user->read($this->data['login'])['pass'] !== $this->current_pass) {
                $this->errors['pass'] = 'Password wrong';
                
                return false;
            }

            return true;
        }

    }
