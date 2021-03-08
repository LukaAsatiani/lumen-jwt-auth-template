<?php 

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function unique_random($table, $col, $chars = 21){
    $unique = false;
    $tested = [];

    do{
        $random = Str::random($chars);
        if( in_array($random, $tested) ){
            continue;
        }
        $count = DB::table($table)->where($col, '=', $random)->count();
        $tested[] = $random;
        if( $count == 0){
            $unique = true;
        }
    }
    while(!$unique);
    return $random;
}