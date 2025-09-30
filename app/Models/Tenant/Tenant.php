<?php

namespace App\Models\Tenant;

use Illuminate\Support\Facades\DB;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    protected $fillable = [
        'name',
        'domain',
        'database',
    ];

    public static function booted(): void
    {
        static::creating(function (Tenant $tenant) {
            if (!str_starts_with($tenant->database, 'meetyy_api_')) {
                $tenant->database = 'meetyy_api_' . $tenant->database;
            }
        });

        static::created(function (Tenant $tenant) {
            $tenant->createDatabase();
        });

        static::saving(function (Tenant $tenant) {
            if (!str_starts_with($tenant->database, 'meetyy_api_')) {
                $tenant->database = 'meetyy_api_' . $tenant->database;
            }
        });

        static::updating(function (Tenant $tenant) {
            if (!str_starts_with($tenant->database, 'meetyy_api_')) {
                $tenant->database = 'meetyy_api_' . $tenant->database;
            }
        });

        static::deleted(function (Tenant $tenant) {
            $tenant->dropDatabase();
        });
    }

    /**
     * Create the tenant's database
     */
    public function createDatabase(): void
    {
        if (!$this->database) {
            return;
        }

        try {
            $query = "CREATE DATABASE IF NOT EXISTS `{$this->database}`";
            DB::statement($query);
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }

    /**
     * Drop the tenant's database
     */
    public function dropDatabase(): void
    {
        if (!$this->database) {
            return;
        }

        try {
            $query = "DROP DATABASE IF EXISTS `{$this->database}`";
            DB::statement($query);
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }
}


