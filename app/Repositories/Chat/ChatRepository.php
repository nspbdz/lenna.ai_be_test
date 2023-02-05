<?php

namespace App\Repositories\Chat;

use LaravelEasyRepository\Repository;

interface ChatRepository extends Repository{

    public function chat($request);
    public function byId($request);
    public function index();
}
