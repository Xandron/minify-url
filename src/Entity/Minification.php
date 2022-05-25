<?php


namespace App\Entity;

use DateTime;
use App\Entity\Traits\ObserveChangesTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Forms
 * @package App\Entity
 * @ORM\Table(name="minification")
 * @ORM\Entity(repositoryClass="App\Repository\MinificationRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="entity")
 */
class Minification implements EntityInterface, ObserveChangesInterface
{
    use ObserveChangesTrait;

    /**
     * @ORM\Id()
     * @ORM\Column(
     *     type="integer",
     *     unique=true,
     *     length=11,
     *     nullable=false,
     *     options={"unsigned":true, "comment":"ID"}
     * )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=false,
     *     name="origin_url",
     *     options={"comment":"Original url"}
     * )
     */
    private string $originUrl;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=10,
     *     nullable=false,
     *     unique=true,
     *     name="short_url",
     *     options={"comment":"Short url"}
     * )
     */
    private string $shortUrl;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     nullable=false,
     *     options={"comment":"Life time short url"}
     * )
     */
    private DateTime $expired;

    /**
     * @ORM\OneToOne(targetEntity="Statistic", mappedBy="minification")
     */
    private ?Statistic $statistic;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOriginUrl(): string
    {
        return $this->originUrl;
    }

    /**
     * @param string $originUrl
     * @return Minification
     */
    public function setOriginUrl(string $originUrl): self
    {
        $this->originUrl = $originUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    /**
     * @param string $shortUrl
     * @return Minification
     */
    public function setShortUrl(string $shortUrl): self
    {
        $this->shortUrl = $shortUrl;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpired(): DateTime
    {
        return $this->expired;
    }

    /**
     * @param DateTime $expired
     * @return Minification
     */
    public function setExpired(DateTime $expired): self
    {
        $this->expired = $expired;
        return $this;
    }

    /**
     * @return Statistic
     */
    public function getStatistic(): ?Statistic
    {
        return $this->statistic;
    }

}