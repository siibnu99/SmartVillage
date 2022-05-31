<?php
function admin_url($url = null)
{
    $adminUrl = getenv("app.adminurl");
    return base_url($adminUrl . '/' . $url);
}
