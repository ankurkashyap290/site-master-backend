<?php

namespace App\Repositories\Logs;

use App\Models\Logs\TransportBillingLog;

/**
 * TransportLog Repository
 */
class TransportBillingLogRepository extends TransportLogRepository
{
    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return TransportBillingLog::class;
    }
}
