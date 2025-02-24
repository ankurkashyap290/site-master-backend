<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\ApiBaseController;
use App\Facades\Config;

class ConfigController extends ApiBaseController
{
    /**
     * @api {get} /config Get config data
     * @apiVersion 0.0.1
     * @apiGroup Configuration
     * @apiName Get config data
     *
     * @apiSuccessExample {json} Success-Response:
     *    HTTP/1.1 200 OK
     *    {
     *        "frontend":{
     *            "apiEndpoint":"http:\/\/api.journey.local\/api\/"
     *        },
     *        "roles":{
     *            "Super Admin":1,
     *            "Organization Admin":2,
     *            "Upper Management":3,
     *            "Facility Admin":4,
     *            "Master User":5,
     *            "Administrator":6
     *        },
     *        "equipment":{
     *            "ambulatory":"Ambulatory",
     *            "stretcher":"Stretcher",
     *            "wheelchair":"Wheelchair"
     *        },
     *        "colors":{
     *            "1":{
     *                "value":"FFE0B2",
     *                "type":"internal"
     *            },
     *            "2":{
     *                "value":"FFCC80",
     *                "type":"internal"
     *            },
     *            "3":{
     *                "value":"FFB74D",
     *                "type":"internal"
     *            },
     *            "4":{
     *                "value":"FFA726",
     *                "type":"internal"
     *            },
     *            "5":{
     *                "value":"FF9800",
     *                "type":"internal"
     *            },
     *            "6":{
     *                "value":"FB8C00",
     *                "type":"internal"
     *            },
     *            "7":{
     *                "value":"F57C00",
     *                "type":"internal"
     *            },
     *            "8":{
     *                "value":"EF6C00",
     *                "type":"internal"
     *            },
     *            "9":{
     *                "value":"d7ccc8",
     *                "type":"external"
     *            },
     *            "10":{
     *                "value":"bcaaa4",
     *                "type":"external"
     *            },
     *            "11":{
     *                "value":"a1887f",
     *                "type":"external"
     *            },
     *            "12":{
     *                "value":"8d6e63",
     *                "type":"external"
     *            },
     *            "13":{
     *                "value":"795548",
     *                "type":"external"
     *            },
     *            "14":{
     *                "value":"6d4c41",
     *                "type":"external"
     *            },
     *            "15":{
     *                "value":"5d4037",
     *                "type":"external"
     *            },
     *            "16":{
     *                "value":"4e342e",
     *                "type":"external"
     *            }
     *        },
     *        "transport_type":{
     *            "ambulatory":"Ambulatory",
     *            "stretcher":"Stretcher",
     *            "wheelchair":"Wheelchair",
     *            "passenger":"Passenger"
     *        },
     *        "transportation_type":{
     *            "internal":"Internal",
     *            "external":"External"
     *        },
     *        "timezones":[
     *            "America/Adak",
     *            "America/Anchorage",
     *            "America/Anguilla",
     *            "America/Antigua",
     *            "America/Araguaina",
     *            "America/Argentina/Buenos_Aires",
     *            "America/Argentina/Catamarca",
     *            "America/Argentina/Cordoba",
     *            "America/Argentina/Jujuy",
     *            "America/Argentina/La_Rioja",
     *            "America/Argentina/Mendoza",
     *            "America/Argentina/Rio_Gallegos",
     *            "America/Argentina/Salta",
     *            "America/Argentina/San_Juan",
     *            "America/Argentina/San_Luis",
     *            "America/Argentina/Tucuman",
     *            "America/Argentina/Ushuaia",
     *            "America/Aruba",
     *            "America/Asuncion",
     *            "America/Atikokan",
     *            "America/Bahia",
     *            "America/Bahia_Banderas",
     *            "America/Barbados",
     *            "America/Belem",
     *            "America/Belize",
     *            "America/Blanc-Sablon",
     *            "America/Boa_Vista",
     *            "America/Bogota",
     *            "America/Boise",
     *            "America/Cambridge_Bay",
     *            "America/Campo_Grande",
     *            "America/Cancun",
     *            "America/Caracas",
     *            "America/Cayenne",
     *            "America/Cayman",
     *            "America/Chicago",
     *            "America/Chihuahua",
     *            "America/Costa_Rica",
     *            "America/Creston",
     *            "America/Cuiaba",
     *            "America/Curacao",
     *            "America/Danmarkshavn",
     *            "America/Dawson",
     *            "America/Dawson_Creek",
     *            "America/Denver",
     *            "America/Detroit",
     *            "America/Dominica",
     *            "America/Edmonton",
     *            "America/Eirunepe",
     *            "America/El_Salvador",
     *            "America/Fort_Nelson",
     *            "America/Fortaleza",
     *            "America/Glace_Bay",
     *            "America/Godthab",
     *            "America/Goose_Bay",
     *            "America/Grand_Turk",
     *            "America/Grenada",
     *            "America/Guadeloupe",
     *            "America/Guatemala",
     *            "America/Guayaquil",
     *            "America/Guyana",
     *            "America/Halifax",
     *            "America/Havana",
     *            "America/Hermosillo",
     *            "America/Indiana/Indianapolis",
     *            "America/Indiana/Knox",
     *            "America/Indiana/Marengo",
     *            "America/Indiana/Petersburg",
     *            "America/Indiana/Tell_City",
     *            "America/Indiana/Vevay",
     *            "America/Indiana/Vincennes",
     *            "America/Indiana/Winamac",
     *            "America/Inuvik",
     *            "America/Iqaluit",
     *            "America/Jamaica",
     *            "America/Juneau",
     *            "America/Kentucky/Louisville",
     *            "America/Kentucky/Monticello",
     *            "America/Kralendijk",
     *            "America/La_Paz",
     *            "America/Lima",
     *            "America/Los_Angeles",
     *            "America/Lower_Princes",
     *            "America/Maceio",
     *            "America/Managua",
     *            "America/Manaus",
     *            "America/Marigot",
     *            "America/Martinique",
     *            "America/Matamoros",
     *            "America/Mazatlan",
     *            "America/Menominee",
     *            "America/Merida",
     *            "America/Metlakatla",
     *            "America/Mexico_City",
     *            "America/Miquelon",
     *            "America/Moncton",
     *            "America/Monterrey",
     *            "America/Montevideo",
     *            "America/Montserrat",
     *            "America/Nassau",
     *            "America/New_York",
     *            "America/Nipigon",
     *            "America/Nome",
     *            "America/Noronha",
     *            "America/North_Dakota/Beulah",
     *            "America/North_Dakota/Center",
     *            "America/North_Dakota/New_Salem",
     *            "America/Ojinaga",
     *            "America/Panama",
     *            "America/Pangnirtung",
     *            "America/Paramaribo",
     *            "America/Phoenix",
     *            "America/Port-au-Prince",
     *            "America/Port_of_Spain",
     *            "America/Porto_Velho",
     *            "America/Puerto_Rico",
     *            "America/Punta_Arenas",
     *            "America/Rainy_River",
     *            "America/Rankin_Inlet",
     *            "America/Recife",
     *            "America/Regina",
     *            "America/Resolute",
     *            "America/Rio_Branco",
     *            "America/Santarem",
     *            "America/Santiago",
     *            "America/Santo_Domingo",
     *            "America/Sao_Paulo",
     *            "America/Scoresbysund",
     *            "America/Sitka",
     *            "America/St_Barthelemy",
     *            "America/St_Johns",
     *            "America/St_Kitts",
     *            "America/St_Lucia",
     *            "America/St_Thomas",
     *            "America/St_Vincent",
     *            "America/Swift_Current",
     *            "America/Tegucigalpa",
     *            "America/Thule",
     *            "America/Thunder_Bay",
     *            "America/Tijuana",
     *            "America/Toronto",
     *            "America/Tortola",
     *            "America/Vancouver",
     *            "America/Whitehorse",
     *            "America/Winnipeg",
     *            "America/Yakutat",
     *            "America/Yellowknife"
     *        ],
     *        "jwt": {
     *            "ttl": 30
     *        }
     *    }
     */
    /**
     * Display all config data.
     */
    public function index()
    {
        return response()->json(Config::export());
    }
}
