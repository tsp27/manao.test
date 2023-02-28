<?php
    session_start();

    class User {

        protected $db = '';
        protected $users = [];
        public $errors = [];

        public function __construct($db) {
            $this->db = $db;
            $this->users = $this->getAllUser();
        }

        /*
         * create user if not exists
         */
        public function create($user) {
            $users = $this->users;
            
            if ($this->userExists($user)) {
                return false;
            }
            
            array_push($users, $user);
            $this->db_content = file_put_contents($this->db, json_encode($users));

            return true;            
        }

        /*
         * get user from db if exists
         */
        public function read($login) {
            $users = $this->users;
            
            if (!$users) {
                return false;
            }
            foreach($users as $user) {
                if ($user['login'] == $login) {
                    return $user;
                }
                return false;
            }


            /*$all_users = $this->getAllUser();
            if (!$all_users) {
                return false;
            }
            foreach($all_users as $user) {
                if ($user['login'] == $login) {
                    return $user;
                }
                return false;
            }*/
        }

        public function update() {
        }

        public function delete() {
        }

        /*
         * get all users from db
         */
        public function getAllUser() {
            $this->db_content = file_get_contents($this->db);
            if ($this->db_content) {
                return $this->users = json_decode($this->db_content, true); // array of users
            }
            
            return []; // empty array
        }

        /*
         * check user exists in db
         */
        public function userExists($user) {
            if (!$this->users) {
                return false; // user doesn't exist if db is empty
            }

            foreach ($this->users as $item) {
                if ($item['login'] == $user['login']) {
                    $this->errors['login'] = 'The login exists';
                }
                if ($item['email'] == $user['email']) {
                    $this->errors['email'] = 'A user with such an email already exists'; 
                }
            }

            if ($this->errors) {
                return true; // user exists (login or email)
            }
            
            return false; // user doesn't exist
        }

    }