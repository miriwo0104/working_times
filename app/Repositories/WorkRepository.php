<?php

namespace App\Repositories;

use App\Models\Work;

class WorkRepository implements WorkRepositoryInterface
{
    /**
     * @var Work
     */
    private $work;

    public function __construct(
        Work $work
    ) {
        $this->work = $work;
    }

    public function register(array $worksInfo) : ?Work
    {   
        return $this->work->create($worksInfo);
    }
}