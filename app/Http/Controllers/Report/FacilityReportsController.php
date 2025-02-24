<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Report\ViewReportRequest;
use App\Repositories\Report\FacilityReportRepository;
use App\Transformers\Event\EventReportingTransformer;
use Illuminate\Http\Response;

class FacilityReportsController extends ApiBaseController
{

    /**
     * Display a listing of the resource.
     *
     * @param ViewReportRequest $request
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function index(ViewReportRequest $request)
    {
        return $this->collection($this->repository->getFacilityReport());
    }

    /**
     * Display facility drilldown view.
     *
     * @param ViewReportRequest $request
     * @param integer $id
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function show(ViewReportRequest $request, $id)
    {
        return $this->item($this->repository->getFacilityDetails($id));
    }

    /**
     * Display facility daily view.
     *
     * @param ViewReportRequest $request
     * @param integer $id
     * @param string $date
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function dailyView(ViewReportRequest $request, $id, $date)
    {
        $this->setTransformer(EventReportingTransformer::class);
        return $this->collection($this->repository->getFacilityDailyView($id, $date));
    }

    /**
     * Get repository name
     *
     * @return string
     */
    public function getRepository(): string
    {
        return FacilityReportRepository::class;
    }
}
