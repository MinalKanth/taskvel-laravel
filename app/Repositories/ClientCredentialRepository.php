<?php

namespace App\Repositories;

use App\Models\ClientCredential;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ClientCredentialRepository
{
    /**
     * Paginate credentials.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return ClientCredential::with('client')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all credentials.
     */
    public function all(): Collection
    {
        return ClientCredential::with('client')
            ->orderBy('portal')
            ->get();
    }

    /**
     * Find credential.
     */
    public function find(int $id): ?ClientCredential
    {
        return ClientCredential::find($id);
    }

    /**
     * Find credential or fail.
     */
    public function findOrFail(int $id): ClientCredential
    {
        return ClientCredential::findOrFail($id);
    }

    /**
     * Create credential.
     */
    public function create(array $data): ClientCredential
    {
        $this->encryptFields($data);

        return ClientCredential::create($data);
    }

    /**
     * Update credential.
     */
    public function update(
        ClientCredential $credential,
        array $data
    ): bool {

        $this->encryptFields($data);

        return $credential->update($data);
    }

    /**
     * Delete credential.
     */
    public function delete(
        ClientCredential $credential
    ): ?bool {

        return $credential->delete();
    }

    /**
     * Restore credential.
     */
    public function restore(int $id): bool
    {
        return ClientCredential::onlyTrashed()
            ->findOrFail($id)
            ->restore();
    }

    /**
     * Force delete credential.
     */
    public function forceDelete(int $id): ?bool
    {
        return ClientCredential::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();
    }

    /**
     * Encrypt sensitive fields.
     */
    protected function encryptFields(array &$data): void
    {
        $fields = [

            'password',

            'pin',

            'security_answer',

            'api_key',

            'api_secret',

        ];

        foreach ($fields as $field) {

            if (
                isset($data[$field]) &&
                !empty($data[$field])
            ) {

                $data[$field] = Crypt::encryptString(
                    $data[$field]
                );

            }

        }
    }

    /**
     * Decrypt one field.
     */
    public function decrypt(
        ClientCredential $credential,
        string $field
    ): ?string {

        if (
            empty($credential->{$field})
        ) {

            return null;

        }

        return Crypt::decryptString(
            $credential->{$field}
        );
    }

    /**
     * Generate secure password.
     */
    public function generatePassword(
        int $length = 16
    ): string {

        return Str::password(
            $length,
            true,
            true,
            true,
            false
        );
    }

    /**
     * Get active credentials.
     */
    public function active(): Collection
    {
        return ClientCredential::where(
            'is_active',
            true
        )->get();
    }

    /**
     * Get expired credentials.
     */
    public function expired(): Collection
    {
        return ClientCredential::whereNotNull(
                'expiry_date'
            )
            ->where(
                'expiry_date',
                '<',
                today()
            )
            ->get();
    }

    /**
     * Get expiring credentials.
     */
    public function expiring(
        int $days = 30
    ): Collection {

        return ClientCredential::whereBetween(
                'expiry_date',
                [
                    today(),
                    today()->addDays($days),
                ]
            )
            ->get();
    }

    /**
     * Get credentials by client.
     */
    public function byClient(
        int $clientId
    ): Collection {

        return ClientCredential::where(
                'client_id',
                $clientId
            )
            ->orderBy('portal')
            ->get();
    }

    /**
     * Statistics.
     */
    public function statistics(): array
    {
        return [

            'total' => ClientCredential::count(),

            'active' => ClientCredential::where(
                'is_active',
                true
            )->count(),

            'expired' => ClientCredential::whereNotNull(
                    'expiry_date'
                )
                ->where(
                    'expiry_date',
                    '<',
                    today()
                )
                ->count(),

            'expiring' => ClientCredential::whereBetween(
                    'expiry_date',
                    [
                        today(),
                        today()->addDays(30),
                    ]
                )
                ->count(),

            'trashed' => ClientCredential::onlyTrashed()
                ->count(),

        ];
    }
}