<?php 

namespace App\Helpers;

use Vinkla\Hashids\Facades\Hashids;



function routeId()
{
    return (int) HashIdsDecode(request()->route('id'));
}

function HashIdsEncode($id)
{
    $func = new Hashids();
    return Hashids::encode($id);
}

function HashIdsDecode($hash)
{
    $func = new Hashids();
    return (string) Hashids::decode($hash)[0];
}