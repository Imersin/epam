<?php

class upd_02 extends upd\BaseUpdate
{
    public function execute()
    {
        $this->oDb->add('INSERT INTO users (created, updated, fullname, email, password, role_id) VALUES(?, ?, ?, ?, ?, ?)')
            ->execute([date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), 'Superadmin', 'example@email.com', password_hash(123, PASSWORD_BCRYPT), 1]);
    }
}