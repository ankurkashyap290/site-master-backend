<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Report\ViewReportRequest;
use App\Repositories\Report\EtcReportRepository;
use App\Transformers\Event\EventReportingTransformer;

class EtcReportsController extends ApiBaseController
{

    /**
     * Display a listing of the resource.
     *
     * @param ViewReportRequest $request
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function index(ViewReportRequest $request)
    {
        return $this->collection($this->repository->getEtcReport());
    }

    /**
     * Display ETC drilldown view.
     *
     * @param ViewReportRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function show(ViewReportRequest $request, $id)
    {
        return $this->item($this->repository->getEtcDetails($id));
    }

    /**
     * Display ETC daily view.
     *
     * @param ViewReportRequest $request
     * @param integer $id
     * @param string $date
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function dailyView(ViewReportRequest $request, $id, $date)
    {
        $this->setTransformer(EventReportingTransformer::class);
        return $this->collection($this->repository->getEtcDailyView($id, $date));
    }

    /**
     * Get repository name
     *
     * @return string
     */
    public function getRepository(): string
    {
        return EtcReportRepository::class;
    }
}
