<?php

namespace App\Services;

use App\Repositories\WorkRepositoryInterface as WorkRepository;
use Carbon\Carbon;

class WorkService
{

    /**
     * @var WorkRepositoryInterface
     */
    private $workRepository;

    public function __construct(
        WorkRepository $workRepository
    ) {
        $this->workRepository = $workRepository;
    }

    public function register(array $worksInfo)
    {
        return $this->workRepository->register($worksInfo);
    }
}
