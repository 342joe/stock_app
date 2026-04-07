<?php
require __DIR__ . '/App/Models/database.php'; // ✅ SI le fichier existe vraiment ici
require __DIR__ . '/App/Models/User.php';

$user = new User();

$user->create([
    'name'       => 'Admin',
    'email'      => 'admin@test.com',
    'password'   => password_hash('123', PASSWORD_DEFAULT),
    'role'       => 'admin',
    'created_at' => date('Y-m-d H:i:s')
]);

echo "✅ Admin créé avec succès";