<?php

$botman = resolve('botman');

$botman->hears('/start', 'App\Http\Controllers\VkController@start');

$botman->hears('/delete',  '\App\Http\Controllers\VkController@delete');

$botman->hears('Url {stringUrl}', 'App\Http\Controllers\VkController@store');
