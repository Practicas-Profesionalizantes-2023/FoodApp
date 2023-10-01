<?php

    interface IModel{
        public function save();
        public function getAll();
        public function get($id);
        public function delete($id);
        public function update($id, $username, $name, $surname, $dni, $province, $role, $state);
        public function from($array);
    }



?>
