<?php

namespace App\Services;

class TenantManager
{
    protected ?int $companyId = null;

    public function setCompanyId(?int $companyId): void
    {
        $this->companyId = $companyId;
    }

    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    public function hasTenant(): bool
    {
        return !is_null($this->companyId);
    }
}
