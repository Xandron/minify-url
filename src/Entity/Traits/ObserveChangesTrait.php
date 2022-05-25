<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait ObserveChangesTrait
{
    /**
     * @ORM\Column(
     *     type="datetime",
     *     nullable=true,
     *     options={"comment":"Creation date"}
     * )
     */
    private DateTime $created;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     nullable=true,
     *     options={"comment":"Update date"}
     * )
     */
    private DateTime $updated;

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     * @return $this
     */
    public function setUpdated(DateTime $updated): self
    {
        $this->updated = $updated;
        return $this;
    }
}