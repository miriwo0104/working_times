<?php

namespace App\Services;

use App\Repositories\DayRepositoryInterface as DayRepository;

class DayService
{

    /**
     * @var DayRepositoryInterface
     */
    private $dayRepository;

    public function __construct(
        DayRepository $dayRepository
    ) {
        $this->dayRepository = $dayRepository;
    }

    public function register(array $daysInfo)
    {
        return $this->dayRepository->register($daysInfo);
    }

}
