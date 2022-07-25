<?php
helper('icon');
function menu($id = null)
{
    $data = [
        ['Dashboard', 'dashboard', icon_home(), [1, 2]],
        ['Surat', 'surat', icon_book(), [1, 2]],
        ['User Management', 'user', icon_userTick(), [2]],
        ['Log Activity', 'log', icon_book(), [1, 2]],
        ['Logout', 'auth/logout', icon_userTick(), [1, 2]],
    ];
    if ($id) {
        foreach ($data as $item) {
            if ($item[0] == $id) {
                return $item;
            }
        }
        return;
    } else {
        return $data;
    }
}
