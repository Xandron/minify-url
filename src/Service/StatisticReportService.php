<?php


namespace App\Service;

use App\DTO\StatisticDTO;
use App\Repository\StatisticRepository;

class StatisticReportService
{
    /**
     * @var StatisticRepository
     */
    private StatisticRepository $statisticRepository;

    /**
     * @var StatisticDTO
     */
    private StatisticDTO $statisticDTO;

    /**
     * StatisticReportService constructor.
     *
     * @param StatisticRepository $statisticRepository
     * @param StatisticDTO $statisticDTO
     */
    public function __construct(
        StatisticRepository     $statisticRepository,
        StatisticDTO            $statisticDTO
    ) {
        $this->statisticRepository = $statisticRepository;
        $this->statisticDTO = $statisticDTO;
    }

    /**
     * @param array $statistics
     * @return array|StatisticDTO
     */
    public function getStatistics($statistics = []): array
    {
        foreach ($this->statisticRepository->findAll() as $statistic) {
            $statistics[] = $this->statisticDTO::transform($statistic);
        }

        return $statistics;
    }

}