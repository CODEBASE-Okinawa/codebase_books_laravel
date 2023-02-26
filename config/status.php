<?php

const MY_LENDING     = '現在借りています';
const MY_RESERVATION = '予約しています';
const OTHER_LENDING  = '貸出中';
const NO_LENDING     = '貸出可能';

const ADMIN    = 1;
const NO_ADMIN = 0;

return [
    'bg-color' => [
        MY_LENDING     => 'bg-sky-500',
        MY_RESERVATION => 'bg-yellow-300',
        OTHER_LENDING  => 'bg-red-600',
        NO_LENDING     => 'bg-lime-500',
    ],
];
