<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Contract;
use App\Repositories\Contracts\ContractRepositoryInterface;
use App\Services\ContractService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;

beforeEach(function () {
    Storage::fake('local');
    $this->repository = Mockery::mock(ContractRepositoryInterface::class);
    $this->service = new ContractService($this->repository);
});

afterEach(function () {
    Mockery::close();
});

it('should create a contract with an uploaded file', function () {
    $file = UploadedFile::fake()->create('contract.pdf', 100);
    $data = ['client_id' => 1, 'value' => 1000];

    $this->repository->shouldReceive('create')
        ->once()
        ->with(Mockery::on(function ($arg) {
            return $arg['client_id'] === 1 && str_contains($arg['file_path'], 'contracts/');
        }))
        ->andReturn(new Contract());

    $this->service->create($data, $file);
});

it('should delete a contract and its physical file', function () {
    $contract = new Contract(['file_path' => 'contracts/test.pdf']);
    $contract->id = 1;
    
    $this->repository->shouldReceive('findOrFail')
        ->with(1)
        ->andReturn($contract);

    $this->repository->shouldReceive('delete')
        ->once()
        ->with(1);

    Storage::disk('local')->put('contracts/test.pdf', 'content');

    $this->service->delete(1);

    Storage::disk('local')->assertMissing('contracts/test.pdf');
});
