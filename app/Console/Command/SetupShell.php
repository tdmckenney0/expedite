<?php

App::uses('AppShell', 'Console/Command');

class SetupShell extends AppShell {

    public $uses = array('Users.User');

    public function main() {

        $this->User->create(array(
            'User' => [
                'is_superuser' => true,
                'username' => 'admin',
                'password' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'change_password' => true,
                'email' => 'admin@example.com'
            ]
        ));

        $this->User->save();

    }
}

