<?php


namespace App\Service;

use App\Entity\Minification;
use App\Repository\MinificationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;

class MinificationService
{
    private const SHORT_URL_LENGTH = 8;
    private const SHORT_URL_FIRST_CHAR = 0;

    /**
     * @var MinificationRepository
     */
    private MinificationRepository $minificationRepository;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * MinificationService constructor.
     *
     * @param MinificationRepository $minificationRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(MinificationRepository $minificationRepository, EntityManagerInterface $entityManager)
    {
        $this->minificationRepository = $minificationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $params
     * @return false|string
     * @throws Exception
     */
    public function process(array $params)
    {
        $expiredUrl = $this->generateExpiredUrl($params['expired']);
        $shortUrl = $this->generateShortUrl($params['url'], $params['expired']);
        $minification = $this->prepareMinificationData(
            $expiredUrl,
            $params['url'],
            $shortUrl
        );

        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->persist($minification);
            $this->entityManager->flush();
            $this->entityManager->commit();


            return $this->shortUrlCompiler($shortUrl);
        } catch (\Exception $exception) {
            $this->entityManager->rollback();

            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @param int $expiredUrlTimeInMinutes
     * @return DateTime
     */
    private function generateExpiredUrl(int $expiredUrlTimeInMinutes): DateTime
    {
        return (new DateTime)->modify("+{$expiredUrlTimeInMinutes} minutes");
    }

    /**
     * @param string $url
     * @param int $expired
     * @return false|string
     */
    private function generateShortUrl(string $url, int $expired)
    {
        $consistenceUrl = $url . $expired;
        $hashUrl = md5($consistenceUrl);

        return substr($hashUrl,self::SHORT_URL_FIRST_CHAR,self::SHORT_URL_LENGTH);
    }

    /**
     * @param DateTime $expiredUrl
     * @param string $originUrl
     * @param string $shortUrl
     * @return Minification
     * @throws NonUniqueResultException
     */
    private function prepareMinificationData(
        DateTime    $expiredUrl,
        string      $originUrl,
        string      $shortUrl
    ): Minification {
        $dateNow = new DateTime;

        if ($minification = $this->minificationRepository->findOneWithFilter($originUrl)) {
            $minification->setExpired($expiredUrl);
            $minification->setUpdated($dateNow);

            return $minification;
        }

        $minification = new Minification();

        $minification->setOriginUrl($originUrl);
        $minification->setShortUrl($shortUrl);
        $minification->setCreated($dateNow);
        $minification->setUpdated($dateNow);
        $minification->setExpired($expiredUrl);

        return $minification;
    }

    /**
     * @param string $url
     * @return string
     */
    private function shortUrlCompiler(string $url): string
    {
        return $_SERVER['REQUEST_SCHEME'] . ':/' . $_SERVER['SERVER_NAME'] . '/' . $url;
    }

}