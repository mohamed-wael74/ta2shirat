<?php

return [
    'roles_structure' => [
        'superadmin' => [
            'countries' => 'r,u',
            'employment_types' => 'c,r,u,d',
            'visa_types' => 'c,r,u,d',
            'users' => 'c,r,u',
            'roles' => 'c,r,u,d',
            'permission_groups' => 'c,r,u,d',
            'role_user' => 'c,d',
            'selling_visas' => 'r,u',
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
