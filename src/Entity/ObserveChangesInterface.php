<?php

declare(strict_types=1);

namespace App\Entity;

interface ObserveChangesInterface
{
    public function getCreated(): \DateTime;

    public function setCreated(\DateTime $created): self;

    public function getUpdated(): \DateTime;

    public function setUpdated(\DateTime $updated);
}