<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'Made',
                'password'   => password_hash('admin', PASSWORD_BCRYPT),
                'nama_lengkap'      => 'I Made Gede Anune',
                'level'      => 'admin'
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
