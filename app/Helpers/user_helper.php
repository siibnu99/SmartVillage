<?php
function role_access($id = NULL)
{
    $roleAccess = [
        [1, 'user', 'User'],
        [2, 'admin', 'Admin'],
        [3, 'guest', 'Guest'],
    ];
    if ($id) {
        foreach ($roleAccess as $role) {
            if ($role[0] == $id) {
                return $role;
            }
        }
    }
    return $roleAccess;
}
