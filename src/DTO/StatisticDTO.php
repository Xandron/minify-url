<?php


namespace App\DTO;

use App\Entity\Statistic;
use DateTime;

class StatisticDTO
{
    public string $originUrl;
    public string $shortUrl;
    public DateTime $created;
    public DateTime $expired;
    public int $transitionsCount;

    /**
     * @param Statistic $statistic
     * @return StatisticDTO
     */
    public static function transform(Statistic $statistic): StatisticDTO
    {
        $dto = new self();

        $dto->originUrl         = $statistic->getMinification()->getOriginUrl();
        $dto->shortUrl          = $statistic->getMinification()->getShortUrl();
        $dto->created           = $statistic->getMinification()->getCreated();
        $dto->expired           = $statistic->getMinification()->getExpired();
        $dto->transitionsCount  = $statistic->getTransitionsCount();
        return $dto;
    }
}