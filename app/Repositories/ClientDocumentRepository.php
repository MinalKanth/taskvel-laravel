<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository
{
    /**
     * Get paginated clients.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Client::latest()->paginate($perPage);
    }

    /**
     * Get all clients.
     */
    public function all(): Collection
    {
        return Client::orderBy('company_name')->get();
    }

    /**
     * Find client by ID.
     */
    public function find(int $id): ?Client
    {
        return Client::find($id);
    }

    /**
     * Find client or fail.
     */
    public function findOrFail(int $id): Client
    {
        return Client::findOrFail($id);
    }

    /**
     * Create client.
     */
    public function create(array $data): Client
    {
        return Client::create($data);
    }

    /**
     * Update client.
     */
    public function update(Client $client, array $data): bool
    {
        return $client->update($data);
    }

    /**
     * Delete client.
     */
    public function delete(Client $client): ?bool
    {
        return $client->delete();
    }

    /**
     * Restore client.
     */
    public function restore(int $id): bool
    {
        return Client::onlyTrashed()
            ->findOrFail($id)
            ->restore();
    }

    /**
     * Force delete client.
     */
    public function forceDelete(int $id): ?bool
    {
        return Client::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();
    }

    /**
     * Get active clients.
     */
    public function active(): Collection
    {
        return Client::where('status', 'Active')->get();
    }

    /**
     * Search clients.
     */
    public function search(string $keyword): Collection
    {
        return Client::where('company_name', 'like', "%{$keyword}%")
            ->orWhere('client_code', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->orWhere('phone', 'like', "%{$keyword}%")
            ->get();
    }

    /**
     * Client statistics.
     */
    public function statistics(): array
    {
        return [
            'total' => Client::count(),
            'active' => Client::where('status', 'Active')->count(),
            'inactive' => Client::where('status', 'Inactive')->count(),
            'prospects' => Client::where('status', 'Prospect')->count(),
        ];
    }
}