<?php

use Chain\MicroChain;
use test\Book;
use test\User;

include __DIR__ . '/src/autoload.php';
include __DIR__ . '/tests/Book.php';
include __DIR__ . '/tests/User.php';

$ch = new MicroChain();


$result = $ch->initialize(User::class, 'getBook', function($model) {
    return $model->getId();
})->link(Book::class, 'getStat', function ($model) {
    return $model->getId();
});

print $result->getPointer(); //23


