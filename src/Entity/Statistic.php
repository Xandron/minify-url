<?php


namespace App\Entity;

use App\Entity\Traits\ObserveChangesTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Forms
 * @package App\Entity
 * @ORM\Table(name="statistic")
 * @ORM\Entity(repositoryClass="App\Repository\StatisticRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="entity")
 */
class Statistic implements EntityInterface, ObserveChangesInterface
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
     * @ORM\OneToOne(targetEntity="App\Entity\Minification", inversedBy="statistic", cascade={"persist"})
     * @ORM\JoinColumn(name="minification_id", referencedColumnName="id")
     */
    private Minification $minification;

    /**
     * @ORM\Column(
     *     type="integer",
     *     nullable=false,
     *     name="transitions_count",
     *     options={"comment":"Number of transitions"}
     * )
     */
    private int $transitionsCount;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Minification
     */
    public function getMinification(): Minification
    {
        return $this->minification;
    }

    /**
     * @param Minification $minification
     * @return Statistic
     */
    public function setMinification(Minification $minification): self
    {
        $this->minification = $minification;
        return $this;
    }

    /**
     * @return int
     */
    public function getTransitionsCount(): int
    {
        return $this->transitionsCount;
    }

    /**
     * @param int $transitionsCount
     * @return Statistic
     */
    public function setTransitionsCount(int $transitionsCount): self
    {
        $this->transitionsCount = $transitionsCount;
        return $this;
    }
}