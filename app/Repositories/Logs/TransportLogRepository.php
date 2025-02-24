<?php

/**
 * TransportLog repository.
 */

namespace App\Repositories\Logs;

use App\Models\Logs\TransportLog;
use App\Repositories\Repository;

/**
 * TransportLog Repository
 */
class TransportLogRepository extends Repository
{
    public function getFilteredList($filters)
    {
        $perPage = 15;
        $fromDate = $filters['from'] ?? '';
        $toDate = $filters['to'] ?? '';
        $this->model = $this->model->where('facility_id', (int)$filters['facilityId']);
        if ($fromDate) {
            $this->model = $this->model->where('date', '>=', $fromDate);
        }
        if ($toDate) {
            $this->model = $this->model->where('date', '<=', $toDate);
        }
        $orderBy = 'desc';
        if ($fromDate || $toDate) {
            $orderBy = 'asc';
            $perPage = $this->model->get()->count();
        }
        $this->model = $this->model->orderBy('date', $orderBy);
        $paginated = $this->model->orderBy('date', 'desc')->paginate($perPage);
        $paginated->appends('limit', $perPage);
        $paginated->appends('from', $fromDate);
        $paginated->appends('to', $toDate);
        return $paginated;
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
    }

    /**
     * Define model name.
     *
     * @return string
     */
    public function model(): string
    {
        return TransportLog::class;
    }
}
