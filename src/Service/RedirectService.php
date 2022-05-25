<?php


namespace App\Service;

use App\Repository\MinificationRepository;
use Exception;

class RedirectService
{
    private const EXCEPTION_URL_NOT_FOUND_MESSAGE = 'Url not found';

    /**
     * @var MinificationRepository
     */
    private MinificationRepository $minificationRepository;

    /**
     * @var StatisticService
     */
    private StatisticService $statisticService;

    /**
     * RedirectService constructor.
     *
     * @param MinificationRepository $minificationRepository
     * @param StatisticService $statisticService
     */
    public function __construct(
        MinificationRepository  $minificationRepository,
        StatisticService        $statisticService
    ) {
        $this->minificationRepository = $minificationRepository;
        $this->statisticService = $statisticService;
    }

    /**
     * @param array $params
     * @return string
     * @throws Exception
     */
    public function getOriginUrl(array $params): string
    {
        $minification = $this->minificationRepository->findOneByShortUrl($params['shortUrl']);

        if (!$minification) {
            throw new Exception(self::EXCEPTION_URL_NOT_FOUND_MESSAGE);
        }

        $this->statisticService->saveStatistic($minification);

        return $minification->getOriginUrl();
    }

}