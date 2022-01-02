<?php

namespace App\Repositories;

use App\Models\Day;

class DayRepository implements DayRepositoryInterface
{
    /**
     * @var Day
     */
    private $day;

    public function __construct(
        Day $day
    ) {
        $this->day = $day;
    }

    public function register(array $daysInfo) : ?Day
    {   
        return $this->day->create($daysInfo);
    }

    public function getById(int $id)
    {
        return $this->day->find($id);
    }

    
}
