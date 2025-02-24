<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Bidding\AcceptDriverRequest;
use App\Http\Requests\Bidding\DeclineAllDriversRequest;
use App\Http\Requests\Bidding\UpdateAcceptedDriverFeeRequest;
use App\Http\Requests\Bidding\ListEventRequest;
use App\Http\Requests\Bidding\AssignDriversRequest;
use App\Repositories\Event\BiddingRepository;
use App\Transformers\Bidding\EventTransformer;
use Illuminate\Http\Response;

class BiddingController extends ApiBaseController
{
    /**
     * @api {get} /bidding Get events of a specific status.
     * @apiPermission Authenticated
     * @apiVersion 1.6.0
     * @apiGroup Events
     * @apiName Get events by scope.
     *
     * @apiParam {String="unassigned","pending","accepted"} [status] Filter by event status.
     * @apiParam {String="id","name","datetime"} [order_by] Ordering column name
     * @apiParam {String="ASC","DESC"} [order] Ordering direction. (case-insensitive)
     * @apiParam {Number} [page] If sent can paginate the list and receive a meta data
     *
     * @apiSuccess {String="events"} type Response type.
     * @apiSuccess {Number} id Event id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.date Event date (format = 'yyyy-mm-dd').
     * @apiSuccess {String} attributes.description Event description.
     * @apiSuccess {String} attributes.end_time Event end time (format = 'hh:mm:ss').
     * @apiSuccess {Number} attributes.facility_id Event Facility ID.
     * @apiSuccess {Object} attributes.location Event Location.
     * @apiSuccess {Number} attributes.location.id Location ID.
     * @apiSuccess {String} attributes.location.name Location name.
     * @apiSuccess {String} attributes.location.phone Location phone number.
     * @apiSuccess {String} attributes.location.address Location address.
     * @apiSuccess {String} attributes.location.city Location city name.
     * @apiSuccess {String} attributes.location.state Location state code.
     * @apiSuccess {String} attributes.location.postcode Location postal code.
     * @apiSuccess {String} attributes.name Event name.
     * @apiSuccess {Object} attributes.passengers Passengers data.
     * @apiSuccess {Number} attributes.passengers.id Passenger ID.
     * @apiSuccess {Number} attributes.passengers.client_id Passenger Client ID.
     * @apiSuccess {String} attributes.passengers.name Passenger name.
     * @apiSuccess {String} attributes.passengers.room_number Passenger room #.
     * @apiSuccess {Object} attributes.passengers.appointments Passenger Appointments data.
     * @apiSuccess {Number} attributes.passengers.appointments.id Appointment ID.
     * @apiSuccess {String} attributes.passengers.appointments.time Appointment time.
     * @apiSuccess {Object} attributes.passengers.appointments.location Appointment Location.
     * @apiSuccess {Number} attributes.passengers.appointments.location.id Location ID.
     * @apiSuccess {String} attributes.passengers.appointments.location.name Location name.
     * @apiSuccess {String} attributes.passengers.appointments.location.phone Location phone number.
     * @apiSuccess {String} attributes.passengers.appointments.location.address Location address.
     * @apiSuccess {String} attributes.passengers.appointments.location.city Location city name.
     * @apiSuccess {String} attributes.passengers.appointments.location.state Location state code.
     * @apiSuccess {String} attributes.passengers.appointments.location.postcode Location postal code.
     * @apiSuccess {Object} attributes.recurrences Event recurrences.
     * @apiSuccess {String} attributes.recurrences.date Recurrence date.
     * @apiSuccess {String} attributes.recurrences.start_time Recurrence start time.
     * @apiSuccess {String} attributes.recurrences.end_time Recurrence end time.
     * @apiSuccess {String} attributes.rrule Recurrence rule (format = RFC 2445 / RRULE).
     * @apiSuccess {String} attributes.start_time Event start time (format = 'hh:mm:ss').
     * @apiSuccess {String} attributes.transport_type Event transport type.
     * @apiSuccess {Number} attributes.transportation_type Event transportation type.
     * @apiSuccess {Object} attributes.user Event User (creator) data.
     * @apiSuccess {Number} attributes.user.id Event User id.
     * @apiSuccess {String} attributes.user.email Event User email id.
     * @apiSuccess {String} attributes.user.first_name Event User first name.
     * @apiSuccess {String} attributes.user.middle_name Event User middle name.
     * @apiSuccess {String} attributes.user.last_name Event User last name.
     * @apiSuccess {Object} attributes.drivers Drivers data.
     * @apiSuccess {Number} attributes.drivers.id Driver ID.
     * @apiSuccess {Number} attributes.drivers.etc_id Driver ETC ID.
     * @apiSuccess {Number} attributes.drivers.user_id Driver User ID.
     * @apiSuccess {String} attributes.drivers.status Driver status.
     * @apiSuccess {String} attributes.drivers.name Driver name.
     * @apiSuccess {String} attributes.drivers.emails Driver emails.
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": [
     *            {
     *                "type":"events",
     *                "id":"1",
     *                "attributes":{
     *                    "name":"Ann goes to the Dentist",
     *                    "date":"2018-05-05",
     *                    "start_time":"04:05:50",
     *                    "end_time":"08:06:46",
     *                    "rrule":null,
     *                    "recurrences":[
     *                        {
     *                            "date":"2018-05-05",
     *                            "start_time":"04:05:50",
     *                            "end_time":"08:06:46"
     *                        }
     *                    ],
     *                    "transport_type":"ambulatory",
     *                    "transportation_type":"external",
     *                    "description":"",
     *                    "user":{
     *                        "id":4,
     *                        "first_name":"Sylvia",
     *                        "middle_name":"Silver",
     *                        "last_name":"Pine",
     *                        "email":"fa@silverpine.test"
     *                    },
     *                    "facility_id":1,
     *                    "location":{
     *                        "id":1,
     *                        "name":"Lynch, Kunde and Dach",
     *                        "phone":"+1 (374) 561-2164",
     *                        "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                        "city":"Ferryborough",
     *                        "state":"CA",
     *                        "postcode":"23692-3371",
     *                        "facility_id":1
     *                    },
     *                    "passengers":[
     *                        {
     *                            "id":1,
     *                            "client_id":null,
     *                            "name":"Ann Smith",
     *                            "room_number":"A113",
     *                            "appointments":[
     *                                {
     *                                    "id":1,
     *                                    "time":"10:00:00",
     *                                    "location":{
     *                                        "id":1,
     *                                        "name":"Lynch, Kunde and Dach",
     *                                        "phone":"+1 (374) 561-2164",
     *                                        "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                                        "city":"Ferryborough",
     *                                        "state":"CA",
     *                                        "postcode":"23692-3371",
     *                                        "facility_id":1
     *                                    }
     *                                }
     *                            ]
     *                        }
     *                    ],
     *                    "drivers":[
     *                        {
     *                            "id":1,
     *                            "etc_id":null,
     *                            "user_id":1,
     *                            "status":"accepted",
     *                            "name":"Peter Parker",
     *                            "emails":"peterparker@spiderman.test",
     *                        }
     *                    ]
     *                },
     *                "links":{
     *                    "self":"http://api.journey.local/events/1"
     *                }
     *            },
     *        ]
     *    }
     */
    /**
     * Display a listing of the resource.
     *
     * @param ListEventRequest $request
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function index(ListEventRequest $request)
    {
        return $this->pagination($this->repository->listByFilters($request->all()));
    }

    /**
     * @api {post} /bidding/assign-drivers/{event_id} Assign drivers to an event.
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Bidding
     * @apiName Assign drivers to the unassigned event
     *
     * @apiParam {String} attributes.transportation_type Event transportation type.
     * @apiParam {Object} attributes.drivers Event drivers.
     * @apiParam {Number} [attributes.drivers.etc_id] Driver ETC ID (for external drivers).
     * @apiParam {Number} [attributes.drivers.user_id] Driver User ID (for internal drivers).
     * @apiParam {String} [attributes.drivers.name] Driver name (for unregistered drivers).
     * @apiParam {String} [attributes.drivers.emails] Driver (for unregistered drivers).
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data":{
     *            "type":"events",
     *            "attributes":{
     *                "status":"internal",
     *                "drivers":[
     *                    {
     *                        "user_id":1,
     *                    }
     *                ],
     *            }
     *        }
     *    }
     *
     * @apiSuccess {String="events"} type Response type.
     * @apiSuccess {Number} id Event id.
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.date Event date (format = 'yyyy-mm-dd').
     * @apiSuccess {String} attributes.description Event description.
     * @apiSuccess {String} attributes.end_time Event end time (format = 'hh:mm:ss').
     * @apiSuccess {Number} attributes.facility_id Event Facility ID.
     * @apiSuccess {Object} attributes.location Event Location.
     * @apiSuccess {Number} attributes.location.id Location ID.
     * @apiSuccess {String} attributes.location.name Location name.
     * @apiSuccess {String} attributes.location.phone Location phone number.
     * @apiSuccess {String} attributes.location.address Location address.
     * @apiSuccess {String} attributes.location.city Location city name.
     * @apiSuccess {String} attributes.location.state Location state code.
     * @apiSuccess {String} attributes.location.postcode Location postal code.
     * @apiSuccess {String} attributes.name Event name.
     * @apiSuccess {Object} attributes.passengers Passengers data.
     * @apiSuccess {Number} attributes.passengers.id Passenger ID.
     * @apiSuccess {Number} attributes.passengers.client_id Passenger Client ID.
     * @apiSuccess {String} attributes.passengers.name Passenger name.
     * @apiSuccess {String} attributes.passengers.room_number Passenger room #.
     * @apiSuccess {Object} attributes.passengers.appointments Passenger Appointments data.
     * @apiSuccess {Number} attributes.passengers.appointments.id Appointment ID.
     * @apiSuccess {String} attributes.passengers.appointments.time Appointment time.
     * @apiSuccess {Object} attributes.passengers.appointments.location Appointment Location.
     * @apiSuccess {Number} attributes.passengers.appointments.location.id Location ID.
     * @apiSuccess {String} attributes.passengers.appointments.location.name Location name.
     * @apiSuccess {String} attributes.passengers.appointments.location.phone Location phone number.
     * @apiSuccess {String} attributes.passengers.appointments.location.address Location address.
     * @apiSuccess {String} attributes.passengers.appointments.location.city Location city name.
     * @apiSuccess {String} attributes.passengers.appointments.location.state Location state code.
     * @apiSuccess {String} attributes.passengers.appointments.location.postcode Location postal code.
     * @apiSuccess {Object} attributes.recurrences Event recurrences.
     * @apiSuccess {String} attributes.recurrences.date Recurrence date.
     * @apiSuccess {String} attributes.recurrences.start_time Recurrence start time.
     * @apiSuccess {String} attributes.recurrences.end_time Recurrence end time.
     * @apiSuccess {String} attributes.rrule Recurrence rule (format = RFC 2445 / RRULE).
     * @apiSuccess {String} attributes.start_time Event start time (format = 'hh:mm:ss').
     * @apiSuccess {String} attributes.transport_type Event transport type.
     * @apiSuccess {Number} attributes.transportation_type Event transportation type.
     * @apiSuccess {Object} attributes.user Event User (creator) data.
     * @apiSuccess {Number} attributes.user.id Event User id.
     * @apiSuccess {String} attributes.user.email Event User email id.
     * @apiSuccess {String} attributes.user.first_name Event User first name.
     * @apiSuccess {String} attributes.user.middle_name Event User middle name.
     * @apiSuccess {String} attributes.user.last_name Event User last name.
     * @apiSuccess {Object} attributes.drivers Drivers data.
     * @apiSuccess {Number} attributes.drivers.id Driver ID.
     * @apiSuccess {Number} attributes.drivers.etc_id Driver ETC ID.
     * @apiSuccess {Number} attributes.drivers.user_id Driver User ID.
     * @apiSuccess {String} attributes.drivers.status Driver status.
     * @apiSuccess {String} attributes.drivers.name Driver name.
     * @apiSuccess {String} attributes.drivers.emails Driver emails.
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": [
     *            {
     *                "type":"events",
     *                "id":"1",
     *                "attributes":{
     *                    "name":"Ann goes to the Dentist",
     *                    "date":"2018-05-05",
     *                    "start_time":"04:05:50",
     *                    "end_time":"08:06:46",
     *                    "rrule":null,
     *                    "recurrences":[
     *                        {
     *                            "date":"2018-05-05",
     *                            "start_time":"04:05:50",
     *                            "end_time":"08:06:46"
     *                        }
     *                    ],
     *                    "transport_type":"ambulatory",
     *                    "transportation_type":"external",
     *                    "description":"",
     *                    "user":{
     *                        "id":4,
     *                        "first_name":"Sylvia",
     *                        "middle_name":"Silver",
     *                        "last_name":"Pine",
     *                        "email":"fa@silverpine.test"
     *                    },
     *                    "facility_id":1,
     *                    "location":{
     *                        "id":1,
     *                        "name":"Lynch, Kunde and Dach",
     *                        "phone":"+1 (374) 561-2164",
     *                        "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                        "city":"Ferryborough",
     *                        "state":"CA",
     *                        "postcode":"23692-3371",
     *                        "facility_id":1
     *                    },
     *                    "passengers":[
     *                        {
     *                            "id":1,
     *                            "client_id":null,
     *                            "name":"Ann Smith",
     *                            "room_number":"A113",
     *                            "appointments":[
     *                                {
     *                                    "id":1,
     *                                    "time":"10:00:00",
     *                                    "location":{
     *                                        "id":1,
     *                                        "name":"Lynch, Kunde and Dach",
     *                                        "phone":"+1 (374) 561-2164",
     *                                        "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                                        "city":"Ferryborough",
     *                                        "state":"CA",
     *                                        "postcode":"23692-3371",
     *                                        "facility_id":1
     *                                    }
     *                                }
     *                            ]
     *                        }
     *                    ],
     *                    "drivers":[
     *                        {
     *                            "id":1,
     *                            "etc_id":null,
     *                            "user_id":1,
     *                            "status":"accepted",
     *                            "name":"Peter Parker",
     *                            "emails":"peterparker@spiderman.test",
     *                        }
     *                    ]
     *                },
     *                "links":{
     *                    "self":"http://api.journey.local/events/1"
     *                }
     *            },
     *        ]
     *    }
     */
    /**
     * Assign drivers to the event
     * @param AssignDriversRequest $request
     * @param integer $eventId
     * @return \Illuminate\Http\Response
     */
    public function assignDrivers(AssignDriversRequest $request, $eventId)
    {
        return $this->item($this->repository->assignDrivers($eventId, $request->data['attributes']));
    }

    /**
     * @api {delete} /bidding/decline-all-drivers:event_id Unassign all driver from specified event
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Bidding
     * @apiName Unassign event drivers
     *
     * @apiParam {Number} event_id Event id
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": []
     *     }
     */
    /**
     * @param DeclineAllDriversRequest $request
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function declineAllDrivers(DeclineAllDriversRequest $request)
    {
        $this->repository->declineAllDrivers($request->event_id);
        return $this->null();
    }

    /**
     * @api {put} /bidding/accept-driver:id Accept driver on pending event
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Bidding
     * @apiName Accept driver
     *
     * @apiParam {Number} id Driver id
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": []
     *     }
     */
    /**
     * @param AcceptDriverRequest $request
     * @SuppressWarnings("unused")
     * @return Response
     */
    public function acceptDriver(AcceptDriverRequest $request)
    {
        $this->repository->acceptDriver($request->id);
        return $this->null();
    }

    /**
     * @api {put} /bidding/update-fee:id Update accepted driver fee
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Bidding
     * @apiName Update accepted driver fee
     *
     * @apiParam {Number} id Driver id
     *
     * @apiParam {String="drivers"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {Object} attributes.fee Accepted driver fee.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data":{
     *            "type":"drivers",
     *            "attributes":{
     *                "fee": 15.5,
     *            }
     *        }
     *    }
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": []
     *     }
     */
    /**
     * @param UpdateAcceptedDriverFeeRequest $request
     * @return Response
     */
    public function updateFee(UpdateAcceptedDriverFeeRequest $request)
    {
        $this->repository->updateFee($request->driver_id, $request['data']['attributes']['fee']);
        return $this->null();
    }

    /**
     * Get repository name
     *
     * @return string
     */
    public function getRepository(): string
    {
        return BiddingRepository::class;
    }

    /**
     * Get transformer type.
     *
     * @return string
     */
    protected function getTransformerType(): string
    {
        return EventTransformer::class;
    }
}
