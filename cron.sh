#!/bin/sh

cd /Users/den/testbot && php artisan schedule:run >> /dev/null 2>&1
