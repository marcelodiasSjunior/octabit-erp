<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ContractStatus;
use App\Models\Contract;
use App\Repositories\Contracts\ContractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class ContractService
{
    private const DISK = 'local';
    private const FOLDER = 'contracts';

    public function __construct(
        private readonly ContractRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($filters, $perPage);
    }

    public function findOrFail(int $id): Contract
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data, ?UploadedFile $file = null): Contract
    {
        return DB::transaction(function () use ($data, $file) {
            if ($file) {
                $data['file_path'] = $this->uploadFile($file);
            }

            $data['status'] = $data['status'] ?? ContractStatus::Draft->value;

            $companyId = app(\App\Services\TenantManager::class)->getCompanyId();
            $data['company_id'] = $companyId;
            $data['sequential_number'] = (DB::table('contracts')
                ->where('company_id', $companyId)
                ->lockForUpdate()
                ->max('sequential_number') ?? 0) + 1;

            return $this->repository->create($data);
        });
    }

    public function update(int $id, array $data, ?UploadedFile $file = null): Contract
    {
        $contract = $this->findOrFail($id);

        if ($file) {
            $this->deletePhysicalFile($contract->file_path);
            $data['file_path'] = $this->uploadFile($file);
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $contract = $this->findOrFail($id);
        
        $this->deletePhysicalFile($contract->file_path);
        
        $this->repository->delete($id);
    }

    /** File Helpers */

    private function uploadFile(UploadedFile $file): string
    {
        return $file->store(self::FOLDER, self::DISK);
    }

    private function deletePhysicalFile(?string $path): void
    {
        if ($path && Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }
}
