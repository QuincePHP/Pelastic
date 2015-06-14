<?php

require_once __DIR__ . '/bootstrap.php';

use Quince\Pelastic\ODM\Pelastic;
use Symfony\Component\EventDispatcher\EventDispatcher;

class User extends Pelastic {

    protected $index = 'users';

    protected $appends = ['usergij'];

    protected $type = 'common';

    public function setUsernameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getUsernameAttribute($value)
    {
        return 'ghanbar';
    }

    public function getUsergijAttribute()
    {
        return "olagh";
    }

}

Pelastic::setEventDispatcher(new EventDispatcher());

$user = new User([
    'username' => 'pretty_jon',
    'name' => 'Jon Snow',
    'nationality' => 'winterfell',
    'created_at' => '2012-4-5'
]);

var_dump($user->toArray());
