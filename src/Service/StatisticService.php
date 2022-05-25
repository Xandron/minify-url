<?php


namespace App\Service;

use App\Entity\Minification;
use App\Entity\Statistic;
use App\Repository\MinificationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class StatisticService
{
    private const TRANSITIONS_ITERATOR = 1;

    /**
     * @var MinificationRepository
     */
    private MinificationRepository $minificationRepository;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * StatisticService constructor.
     *
     * @param MinificationRepository $minificationRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        MinificationRepository $minificationRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->minificationRepository = $minificationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Minification $minification
     * @throws Exception
     */
    public function saveStatistic(Minification $minification)
    {
        $statistic = $this->prepareStatisticData($minification);
        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->persist($statistic);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $exception) {
            $this->entityManager->rollback();

            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param Minification $minification
     * @return Statistic
     */
    private function prepareStatisticData(Minification $minification): Statistic
    {
        $dateTime = new DateTime();

        if ($statistic = $minification->getStatistic()) {
            $statistic->setTransitionsCount($this->transitionsCount($statistic));
            $statistic->setUpdated($dateTime);
            return $statistic;
        }

        $statistic = new Statistic();
        $statistic->setCreated($dateTime);
        $statistic->setUpdated($dateTime);
        $statistic->setTransitionsCount($this->transitionsCount($statistic));
        $statistic->setMinification($minification);

        return $statistic;
    }

    /**
     * @param Statistic $statistic
     * @return int
     */
    private function transitionsCount(Statistic $statistic): int
    {
        return $statistic ? $statistic->getTransitionsCount() + self::TRANSITIONS_ITERATOR : self::TRANSITIONS_ITERATOR;
    }

}