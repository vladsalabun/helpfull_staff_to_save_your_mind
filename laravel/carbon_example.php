<?php

    try {
        Carbon::parse($get);
    } catch (\Exception $e) {
        die('Invalid date, enduser understands the error message');
    }

    Carbon::today();
    Carbon::now()->subDay(1); // вчора
    Carbon::now()->addDays(1); // сьогдодні
    Carbon::now()->toDateTimeString(); // 2019-20-04 13:05:05
    Carbon::now()->toDateString(); // 2019-20-04
    
    Carbon::createFromDate(2019, 20, 04);