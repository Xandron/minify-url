<?php


namespace App\Repository;

use App\Entity\Minification;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Minification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Minification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Minification[]    findAll()
 * @method Minification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MinificationRepository extends ServiceEntityRepository
{
    /**
     * MinificationRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Minification::class);
    }

    /**
     * @param string $originUrl
     * @return Minification
     * @throws NonUniqueResultException
     */
    public function findOneWithFilter(string $originUrl): ?Minification
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.originUrl = :originUrl')
            ->setParameter('originUrl', $originUrl)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $shortUrl
     * @return Minification|null
     * @throws NonUniqueResultException
     */
    public function findOneByShortUrl(string $shortUrl): ?Minification
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.shortUrl = :shortUrl')
            ->andWhere('m.expired > :now')
            ->setParameter('now', new DateTime())
            ->setParameter('shortUrl', $shortUrl)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $id
     * @return array
     */
    public function findByIdWithFilter(int $id): array
    {
        return $this->createQueryBuilder('a')
            ->select(['a.bio', 'service.name as service_name, astrologer_services.price'])
            ->leftJoin(
                AstrologersServices::class,
                'astrologer_services',
                Join::WITH,
                'astrologer_services.astrologer = a.id')
            ->leftJoin(
                Services::class,
                'service',
                Join::WITH,
                'astrologer_services.service = service.id')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }


}