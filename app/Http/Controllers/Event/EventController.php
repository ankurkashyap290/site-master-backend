<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Event\DeleteEventRequest;
use App\Http\Requests\Event\GetEventRequest;
use App\Http\Requests\Event\ListEventRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\LoggedInRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Repositories\Event\EventRepository;
use App\Transformers\Event\EventTransformer;
use Illuminate\Http\Response;

class EventController extends ApiBaseController
{
    /**
     * @api {get} /events Get event list
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Events
     * @apiName Get event list
     *
     * @apiSuccess {String="events"} type Response type.
     * @apiSuccess {Number} id Event id.
     * @apiSuccess {Object} attributes
     * @apiSuccess {String} attributes.date Event date (format = 'yyyy-mm-dd').
     * @apiSuccess {String} attributes.start_time Event start time (format = 'hh:mm:ss').
     * @apiSuccess {String} attributes.end_time Event end time (format = 'hh:mm:ss').
     * @apiSuccess {String} attributes.end_time Event end time.
     * @apiSuccess {String} attributes.transport_type Event transport type.
     * @apiSuccess {Number} attributes.transportation_type Event transportation type.
     * @apiSuccess {String} attributes.description Event transportation type.
     * @apiSuccess {Object} attributes.user (Owner/Creator).
     * @apiSuccess {Number} attributes.user.id Event user id.
     * @apiSuccess {String} attributes.user.email Event user email id.
     * @apiSuccess {String} attributes.user.first_name Event user first name.
     * @apiSuccess {String} attributes.user.middle_name Event user middle name.
     * @apiSuccess {String} attributes.user.last_name Event user last name.
     * @apiSuccess {Number} attributes.facility_id Event facility id (Owner).
     * @apiSuccess {Object} links
     * @apiSuccess {String} links.self Resource URL
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": [
     *            {
     *                "type": "events",
     *                "id": "1",
     *                "attributes": {
     *                    "name": "Damion goes to the Dentist",
     *                    "date": "2018-05-25",
     *                    "start_time": "12:46:03",
     *                    "end_time": "05:58:35",
     *                    "transport_type": "passenger",
     *                    "transportation_type": "2",
     *                    "description": "",
     *                    "user": {
     *                         "id": 4,
     *                         "email": "fa@silverpine.test",
     *                         "first_name": "Sylvia",
     *                         "middle_name": "Silver",
     *                         "last_name": "Pine"
     *                     },
     *                    "facility_id": 1
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/events/1"
     *                }
     *            },
     *            {
     *                "type": "events",
     *                "id": "2",
     *                "attributes": {
     *                    "name": "Kelsi goes to the Ambulance",
     *                    "date": "2018-05-05",
     *                    "start_time": "14:12:33",
     *                    "end_time": "05:01:01",
     *                    "transport_type": "passenger",
     *                    "transportation_type": "1",
     *                    "description": "",
     *                    "user": {
     *                         "id": 4,
     *                         "email": "fa@silverpine.test",
     *                         "first_name": "Sylvia",
     *                         "middle_name": "Silver",
     *                         "last_name": "Pine"
     *                     },
     *                    "facility_id": 1
     *                },
     *                "links": {
     *                    "self": "http://api.journey.local/events/2"
     *                }
     *            }
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
        return $this->pagination($this->repository->list($request->only('fromDate', 'toDate', 'searchKey')));
    }

    /**
     * @api {post} /events Add new event
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Events
     * @apiName Add new event
     *
     * @apiParam {String="events"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.date Event date (format = 'yyyy-mm-dd').
     * @apiParam {String} [attributes.description] Event description.
     * @apiParam {String} attributes.end_time Event end time (format = 'hh:mm:ss').
     * @apiParam {Number} attributes.facility_id Event Facility ID.
     * @apiParam {Object} attributes.location_id Event Location ID.
     * @apiParam {String} attributes.name Event name.
     * @apiParam {Object[]} attributes.passengers Passengers data.
     * @apiParam {Number} attributes.passengers.id Passenger ID.
     * @apiParam {Number} attributes.passengers.client_id Passenger Client ID.
     * @apiParam {String} attributes.passengers.name Passenger name.
     * @apiParam {String} attributes.passengers.room_number Passenger room #.
     * @apiParam {Object[]} attributes.passengers.appointments Passenger Appointments data.
     * @apiParam {Number} attributes.passengers.appointments.id Appointment ID.
     * @apiParam {String} attributes.passengers.appointments.time Appointment time.
     * @apiParam {Object} attributes.passengers.appointments.location_id Appointment Location ID.
     * @apiParam {String} attributes.rrule Recurrence rule (format = RFC 2445 / RRULE).
     * @apiParam {String} attributes.start_time Event start time (format = 'hh:mm:ss').
     * @apiParam {String} attributes.transport_type Event transport type.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data":{
     *            "type":"events",
     *            "attributes":{
     *                "name":"Ann goes to the Dentist",
     *                "passengers":[
     *                    {
     *                        "id":1,
     *                        "client_id":null,
     *                        "name":"Ann Smith",
     *                        "room_number":"A113",
     *                        "appointments":[
     *                            {
     *                                "id":1,
     *                                "time":"10:00:00",
     *                                "location_id":1
     *                            }
     *                        ]
     *                    }
     *                ],
     *                "date":"2018-05-05",
     *                "start_time":"04:05:50",
     *                "end_time":"08:06:46",
     *                "rrule":null,
     *                "transport_type":"ambulatory",
     *                "description":"",
     *                "location_id":1
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
     * @apiSuccess {Object[]} attributes.passengers Passengers data.
     * @apiSuccess {Number} attributes.passengers.id Passenger ID.
     * @apiSuccess {Number} attributes.passengers.client_id Passenger Client ID.
     * @apiSuccess {String} attributes.passengers.name Passenger name.
     * @apiSuccess {String} attributes.passengers.room_number Passenger room #.
     * @apiSuccess {Object[]} attributes.passengers.appointments Passenger Appointments data.
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
     * @apiSuccess {Object[]} attributes.recurrences Event recurrences.
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
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type":"events",
     *            "id":"1",
     *            "attributes":{
     *                "name":"Ann goes to the Dentist",
     *                "date":"2018-05-05",
     *                "start_time":"04:05:50",
     *                "end_time":"08:06:46",
     *                "rrule":null,
     *                "recurrences":[
     *                    {
     *                        "date":"2018-05-05",
     *                        "start_time":"04:05:50",
     *                        "end_time":"08:06:46"
     *                    }
     *                ],
     *                "transport_type":"ambulatory",
     *                "transportation_type":"external",
     *                "description":"",
     *                "user":{
     *                    "id":4,
     *                    "first_name":"Sylvia",
     *                    "middle_name":"Silver",
     *                    "last_name":"Pine",
     *                    "email":"fa@silverpine.test"
     *                },
     *                "facility_id":1,
     *                "location":{
     *                    "id":1,
     *                    "name":"Lynch, Kunde and Dach",
     *                    "phone":"+1 (374) 561-2164",
     *                    "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                    "city":"Ferryborough",
     *                    "state":"CA",
     *                    "postcode":"23692-3371",
     *                    "facility_id":1
     *                },
     *                "passengers":[
     *                    {
     *                        "id":1,
     *                        "client_id":null,
     *                        "name":"Ann Smith",
     *                        "room_number":"A113",
     *                        "appointments":[
     *                            {
     *                                "id":1,
     *                                "time":"10:00:00",
     *                                "location":{
     *                                    "id":1,
     *                                    "name":"Lynch, Kunde and Dach",
     *                                    "phone":"+1 (374) 561-2164",
     *                                    "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                                    "city":"Ferryborough",
     *                                    "state":"CA",
     *                                    "postcode":"23692-3371",
     *                                    "facility_id":1
     *                                }
     *                            }
     *                        ]
     *                    }
     *                ]
     *            },
     *            "links":{
     *                "self":"http://api.journey.local/events/1"
     *            }
     *        }
     *    }
     *
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Missing attributes
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "errors": [
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes"
     *                },
     *                "detail": "The data.attributes must have between 8 and 9 items."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.transportation_type"
     *                },
     *                "detail": "The data.attributes.transportation type field is required."
     *            }
     *        ]
     *    }
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        return $this->item($this->repository->store($request->only('data')), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /events/:id Get event by ID
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Events
     * @apiName Get specified event
     *
     * @apiParam {Number} id Event id
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
     * @apiSuccess {Object[]} attributes.passengers Passengers data.
     * @apiSuccess {Number} attributes.passengers.id Passenger ID.
     * @apiSuccess {Number} attributes.passengers.client_id Passenger Client ID.
     * @apiSuccess {String} attributes.passengers.name Passenger name.
     * @apiSuccess {String} attributes.passengers.room_number Passenger room #.
     * @apiSuccess {Object[]} attributes.passengers.appointments Passenger Appointments data.
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
     * @apiSuccess {Object[]} attributes.recurrences Event recurrences.
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
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type":"events",
     *            "id":"1",
     *            "attributes":{
     *                "name":"Ann goes to the Dentist",
     *                "date":"2018-05-05",
     *                "start_time":"04:05:50",
     *                "end_time":"08:06:46",
     *                "rrule":null,
     *                "recurrences":[
     *                    {
     *                        "date":"2018-05-05",
     *                        "start_time":"04:05:50",
     *                        "end_time":"08:06:46"
     *                    }
     *                ],
     *                "transport_type":"ambulatory",
     *                "transportation_type":"external",
     *                "description":"",
     *                "user":{
     *                    "id":4,
     *                    "first_name":"Sylvia",
     *                    "middle_name":"Silver",
     *                    "last_name":"Pine",
     *                    "email":"fa@silverpine.test"
     *                },
     *                "facility_id":1,
     *                "location":{
     *                    "id":1,
     *                    "name":"Lynch, Kunde and Dach",
     *                    "phone":"+1 (374) 561-2164",
     *                    "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                    "city":"Ferryborough",
     *                    "state":"CA",
     *                    "postcode":"23692-3371",
     *                    "facility_id":1
     *                },
     *                "passengers":[
     *                    {
     *                        "id":1,
     *                        "client_id":null,
     *                        "name":"Ann Smith",
     *                        "room_number":"A113",
     *                        "appointments":[
     *                            {
     *                                "id":1,
     *                                "time":"10:00:00",
     *                                "location":{
     *                                    "id":1,
     *                                    "name":"Lynch, Kunde and Dach",
     *                                    "phone":"+1 (374) 561-2164",
     *                                    "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                                    "city":"Ferryborough",
     *                                    "state":"CA",
     *                                    "postcode":"23692-3371",
     *                                    "facility_id":1
     *                                }
     *                            }
     *                        ]
     *                    }
     *                ]
     *            },
     *            "links":{
     *                "self":"http://api.journey.local/events/1"
     *            }
     *        }
     *    }
     *
     * @apiError Wrong-id Get a non-existing resource
     *
     * @apiErrorExample {json} Wrong id
     *    HTTP/1.1 401 Unauthorized
     *    {
     *        "errors": [
     *            {
     *                "status": "401",
     *                "source": {
     *                    "pointer": "Illuminate\\Auth\\Access\\AuthorizationException"
     *                },
     *                "detail": "This action is unauthorized."
     *            }
     *        ]
     *    }
     */
    /**
     * Display the specified resource.
     *
     * @param GetEventRequest $request
     * @param  \App\Models\Event\Event  $event
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function show(GetEventRequest $request, $event)
    {
        return $this->item($event);
    }

    /**
     * @api {delete} /events/:id Delete event
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Events
     * @apiName Delete event
     *
     * @apiParam {Number} id Event id.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "data": null
     *     }
     *
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteEventRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function destroy(DeleteEventRequest $request, $id)
    {
        $this->repository->delete($id);
        return $this->null();
    }

    /**
     * @api {put/patch} /events/:id Update event
     * @apiPermission Authenticated
     * @apiVersion 0.0.1
     * @apiGroup Events
     * @apiName Update event
     *
     * @apiParam {Number} id Event id.
     *
     * @apiParam {String="events"} type Request type.
     * @apiParam {Object} attributes
     * @apiParam {String} attributes.date Event date (format = 'yyyy-mm-dd').
     * @apiParam {String} [attributes.description] Event description.
     * @apiParam {String} attributes.end_time Event end time (format = 'hh:mm:ss').
     * @apiParam {Number} attributes.facility_id Event Facility ID.
     * @apiParam {Object} attributes.location_id Event Location ID.
     * @apiParam {String} attributes.name Event name.
     * @apiParam {Object[]} attributes.passengers Passengers data.
     * @apiParam {Number} attributes.passengers.id Passenger ID.
     * @apiParam {Number} attributes.passengers.client_id Passenger Client ID.
     * @apiParam {String} attributes.passengers.name Passenger name.
     * @apiParam {String} attributes.passengers.room_number Passenger room #.
     * @apiParam {Object[]} attributes.passengers.appointments Passenger Appointments data.
     * @apiParam {Number} attributes.passengers.appointments.id Appointment ID.
     * @apiParam {String} attributes.passengers.appointments.time Appointment time.
     * @apiParam {Object} attributes.passengers.appointments.location_id Appointment Location ID.
     * @apiParam {String} attributes.rrule Recurrence rule (format = RFC 2445 / RRULE).
     * @apiParam {String} attributes.start_time Event start time (format = 'hh:mm:ss').
     * @apiParam {String} attributes.transport_type Event transport type.
     * @apiParam {Number} attributes.transportation_type Event transportation type.
     *
     * @apiParamExample {json} Example usage:
     *    body:
     *    {
     *        "data":{
     *            "type":"events",
     *            "attributes":{
     *                "name":"Ann goes to the Dentist",
     *                "passengers":[
     *                    {
     *                        "id":1,
     *                        "client_id":null,
     *                        "name":"Ann Smith",
     *                        "room_number":"A113",
     *                        "appointments":[
     *                            {
     *                                "id":1,
     *                                "time":"10:00:00",
     *                                "location_id":1
     *                            }
     *                        ]
     *                    }
     *                ],
     *                "date":"2018-05-05",
     *                "start_time":"04:05:50",
     *                "end_time":"08:06:46",
     *                "rrule":null,
     *                "transport_type":"ambulatory",
     *                "transportation_type":"external",
     *                "description":"",
     *                "location_id":1
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
     * @apiSuccess {Object[]} attributes.passengers Passengers data.
     * @apiSuccess {Number} attributes.passengers.id Passenger ID.
     * @apiSuccess {Number} attributes.passengers.client_id Passenger Client ID.
     * @apiSuccess {String} attributes.passengers.name Passenger name.
     * @apiSuccess {String} attributes.passengers.room_number Passenger room #.
     * @apiSuccess {Object[]} attributes.passengers.appointments Passenger Appointments data.
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
     * @apiSuccess {Object[]} attributes.recurrences Event recurrences.
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
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "data": {
     *            "type":"events",
     *            "id":"1",
     *            "attributes":{
     *                "name":"Ann goes to the Dentist",
     *                "date":"2018-05-05",
     *                "start_time":"04:05:50",
     *                "end_time":"08:06:46",
     *                "rrule":null,
     *                "recurrences":[
     *                    {
     *                        "date":"2018-05-05",
     *                        "start_time":"04:05:50",
     *                        "end_time":"08:06:46"
     *                    }
     *                ],
     *                "transport_type":"ambulatory",
     *                "transportation_type":"external",
     *                "description":"",
     *                "user":{
     *                    "id":4,
     *                    "first_name":"Sylvia",
     *                    "middle_name":"Silver",
     *                    "last_name":"Pine",
     *                    "email":"fa@silverpine.test"
     *                },
     *                "facility_id":1,
     *                "location":{
     *                    "id":1,
     *                    "name":"Lynch, Kunde and Dach",
     *                    "phone":"+1 (374) 561-2164",
     *                    "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                    "city":"Ferryborough",
     *                    "state":"CA",
     *                    "postcode":"23692-3371",
     *                    "facility_id":1
     *                },
     *                "passengers":[
     *                    {
     *                        "id":1,
     *                        "client_id":null,
     *                        "name":"Ann Smith",
     *                        "room_number":"A113",
     *                        "appointments":[
     *                            {
     *                                "id":1,
     *                                "time":"10:00:00",
     *                                "location":{
     *                                    "id":1,
     *                                    "name":"Lynch, Kunde and Dach",
     *                                    "phone":"+1 (374) 561-2164",
     *                                    "address":"393 Julian Way\nGottliebtown, DE 75960-9164",
     *                                    "city":"Ferryborough",
     *                                    "state":"CA",
     *                                    "postcode":"23692-3371",
     *                                    "facility_id":1
     *                                }
     *                            }
     *                        ]
     *                    }
     *                ]
     *            },
     *            "links":{
     *                "self":"http://api.journey.local/events/1"
     *            }
     *        }
     *    }
     *
     * @apiError Missing-attributes Required attributes missing
     *
     * @apiErrorExample {json} Missing attributes
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "errors": [
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes"
     *                },
     *                "detail": "The data.attributes must have between 8 and 9 items."
     *            },
     *            {
     *                "status": "400",
     *                "source": {
     *                    "pointer": "data.attributes.transportation_type"
     *                },
     *                "detail": "The data.attributes.transportation type field is required."
     *            }
     *        ]
     *    }
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEventRequest $request
     * @param $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, $event)
    {
        return $this->item($this->repository->update($request->only('data'), $event), Response::HTTP_OK);
    }

    /**
     * Get repository name
     *
     * @return string
     */
    public function getRepository(): string
    {
        return EventRepository::class;
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
