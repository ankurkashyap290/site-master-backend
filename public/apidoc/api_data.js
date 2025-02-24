define({ "api": [
  {
    "type": "post",
    "url": "/activation/activate-user",
    "title": "Activate user",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.0.1",
    "group": "Activation",
    "name": "Activate_user_and_log_in_to_system",
    "header": {
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Accept\": \"application/json\"\n  \"Content-Type\": \"application/json\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.token",
            "description": "<p>User access token (sent by email).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.password",
            "description": "<p>User password.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"attributes\": {\n            \"id\": 4,\n            \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\",\n            \"password\": \"secret\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.access_token",
            "description": "<p>Access token.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"Bearer\""
            ],
            "optional": false,
            "field": "attributes.token_type",
            "description": "<p>Access token type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.expires_in",
            "description": "<p>Access token expire time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String/null",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>User phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object/null",
            "optional": false,
            "field": "attributes.color",
            "description": "<p>User color (used for calendar and we only use for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": true,
            "field": "attributes.color.id",
            "description": "<p>User color id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Char",
            "optional": true,
            "field": "attributes.color.value",
            "description": "<p>User color value must be a HEX without # (hashtag).</p>"
          },
          {
            "group": "Success 200",
            "type": "Enum",
            "allowedValues": [
              "\"internal\"",
              "\"external\""
            ],
            "optional": true,
            "field": "attributes.color.type",
            "description": "<p>Driver type (Color depends from Driver type).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"id\": \"4\",\n        \"attributes\": {\n            \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\",\n            \"token_type\": \"bearer\",\n            \"expires_in\": 1800,\n            \"first_name\": \"Greenfield\",\n            \"middle_name\": null,\n            \"last_name\": \"Jones\",\n            \"email\": \"jones.greenfield@journey.test\",\n            \"role_id\": 1,\n            \"color\": null,\n            \"organization\": {\n                \"id\": 1,\n                \"name\": \"Silver Pine Ltd.\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            }\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/user/4\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p>Wrong token sent.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BadRequest",
            "description": "<p>Missing/Wrong api parameters.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"detail\": \"Unauthorized Activation Token\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "BadRequest",
          "content": "HTTP/1.1 400 BadRequest\n{\n   \"errors\": [\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes\"\n           },\n           \"detail\": \"The data.attributes field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.id\"\n           },\n           \"detail\": \"The data.attributes.id field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.token\"\n           },\n           \"detail\": \"The data.attributes.token field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.password\"\n           },\n           \"detail\": \"The data.attributes.password field is required.\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/ActivationController.php",
    "groupTitle": "Activation"
  },
  {
    "type": "get",
    "url": "/activation/activable-user",
    "title": "Get activable user info",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.0.1",
    "group": "Activation",
    "name": "Get_pre_activated_user_info",
    "header": {
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Accept\": \"application/json\",\n  \"Content-Type\": \"application/json\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.token",
            "description": "<p>User access token (sent by email).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"attributes\": {\n            \"id\": 4,\n            \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String/null",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>User phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object/null",
            "optional": false,
            "field": "attributes.color",
            "description": "<p>User color (used for calendar and we only use for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": true,
            "field": "attributes.color.id",
            "description": "<p>User color id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Char",
            "optional": true,
            "field": "attributes.color.value",
            "description": "<p>User color value must be a HEX without # (hashtag).</p>"
          },
          {
            "group": "Success 200",
            "type": "Enum",
            "allowedValues": [
              "\"internal\"",
              "\"external\""
            ],
            "optional": true,
            "field": "attributes.color.type",
            "description": "<p>Driver type (Color depends on Driver type).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n {\n    \"data\": {\n        \"type\": \"users\",\n        \"id\": \"4\",\n        \"attributes\": {\n            \"first_name\": \"Greenfield\",\n            \"middle_name\": null,\n            \"last_name\": \"Jones\",\n            \"email\": \"jones.greenfield@journey.test\",\n            \"role_id\": 1,\n            \"color\": null,\n            \"organization\": {\n                \"id\": 1,\n                \"name\": \"Silver Pine Ltd.\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            }\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/users/4\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p>Wrong token sent.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BadRequest",
            "description": "<p>Missing/Wrong api parameters.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unauthorized",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"detail\": \"Unauthorized Activation Token\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "BadRequest",
          "content": "HTTP/1.1 400 BadRequest\n{\n   \"errors\": [\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes\"\n           },\n           \"detail\": \"The data.attributes field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.id\"\n           },\n           \"detail\": \"The data.attributes.id field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.token\"\n           },\n           \"detail\": \"The data.attributes.token field is required.\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/ActivationController.php",
    "groupTitle": "Activation"
  },
  {
    "type": "post",
    "url": "/auth/change-password",
    "title": "Change password",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Authentication",
    "name": "Change_password_of_authenticated_user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.password",
            "description": "<p>New password for user</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"attributes\": {\n            \"old_password\": \"secret\",\n            \"new_password\": \"super-secret\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n {\n    \"data\": null,\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Bad-Request",
            "description": "<p>Missing/Wrong api parameters.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Bad-Request",
          "content": "HTTP/1.1 400 Bad-Request\n{\n   \"errors\": [\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes\"\n           },\n           \"detail\": \"The data.attributes field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.old_password\"\n           },\n           \"detail\": \"The data.attributes.old_password field is required.\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/ChangePasswordController.php",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/auth/refresh",
    "title": "Get a fresh token",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Authentication",
    "name": "Get_a_fresh_token",
    "header": {
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Accept\": \"application/json\",\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.role",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role.id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.role.name",
            "description": "<p>User role name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object/null",
            "optional": false,
            "field": "attributes.color",
            "description": "<p>User color (used for calendar and we only use for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": true,
            "field": "attributes.color.id",
            "description": "<p>User color id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Char",
            "optional": true,
            "field": "attributes.color.value",
            "description": "<p>User color value must be a HEX without # (hashtag).</p>"
          },
          {
            "group": "Success 200",
            "type": "Enum",
            "allowedValues": [
              "\"internal\"",
              "\"external\""
            ],
            "optional": true,
            "field": "attributes.color.type",
            "description": "<p>Driver type (Color depends on Driver type).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.facilities",
            "description": "<p>All Facilities related to the User.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.policies",
            "description": "<p>User policies.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.facility_id",
            "description": "<p>Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.role_id",
            "description": "<p>Role ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.policies.entity",
            "description": "<p>Entity name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.view",
            "description": "<p>View access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.create",
            "description": "<p>Create access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.update",
            "description": "<p>Update access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.delete",
            "description": "<p>Delete access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"user\",\n        \"id\": \"1\",\n        \"attributes\": {\n            \"first_name\": \"Clark\",\n            \"middle_name\": \"\",\n            \"last_name\": \"Kent\",\n            \"email\": \"sa@journey.test\",\n            \"role\": {\n                \"id\": 1,\n                \"name\": \"Super Admin\"\n            },\n            \"color\": null,\n            \"organization\": {\n                \"id\": null,\n                \"name\": \"\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            },\n            \"facilities\": [],\n            \"policies\": [\n                {\n                    \"id\": 2,\n                    \"facility_id\": 1,\n                    \"role_id\": 6,\n                    \"entity\": \"TransportLog\",\n                    \"view\": 1,\n                    \"create\": 0,\n                    \"update\": 0,\n                    \"delete\": 0,\n                },\n            ],\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/user/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p>User not logged in</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unauthorized",
          "content": " HTTP/1.1 401  Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"source\": {\n                \"pointer\": \"Symfony\\\\Component\\\\HttpKernel\\\\Exception\\\\UnauthorizedHttpException\"\n            },\n            \"detail\": \"Token not provided\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Authentication"
  },
  {
    "type": "get",
    "url": "/auth/me",
    "title": "Get logged in user info",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Authentication",
    "name": "Get_user_info",
    "header": {
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Accept\": \"application/json\",\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.role",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role.id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.role.name",
            "description": "<p>User role name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object/null",
            "optional": false,
            "field": "attributes.color",
            "description": "<p>User color (used for calendar and we only use for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": true,
            "field": "attributes.color.id",
            "description": "<p>User color id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Char",
            "optional": true,
            "field": "attributes.color.value",
            "description": "<p>User color value must be a HEX without # (hashtag).</p>"
          },
          {
            "group": "Success 200",
            "type": "Enum",
            "allowedValues": [
              "\"internal\"",
              "\"external\""
            ],
            "optional": true,
            "field": "attributes.color.type",
            "description": "<p>Driver type (Color depends on Driver type).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.facilities",
            "description": "<p>All Facilities related to the User.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.policies",
            "description": "<p>User policies.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.facility_id",
            "description": "<p>Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.role_id",
            "description": "<p>Role ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.policies.entity",
            "description": "<p>Entity name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.view",
            "description": "<p>View access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.create",
            "description": "<p>Create access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.update",
            "description": "<p>Update access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.delete",
            "description": "<p>Delete access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"user\",\n        \"id\": \"1\",\n        \"attributes\": {\n            \"first_name\": \"Clark\",\n            \"middle_name\": \"\",\n            \"last_name\": \"Kent\",\n            \"email\": \"sa@journey.test\",\n            \"role\": {\n                \"id\": 1,\n                \"name\": \"Super Admin\"\n            },\n            \"color\": null,\n            \"organization\": {\n                \"id\": null,\n                \"name\": \"\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            },\n            \"facilities\": [],\n            \"policies\": [\n                {\n                    \"id\": 2,\n                    \"facility_id\": 1,\n                    \"role_id\": 6,\n                    \"entity\": \"TransportLog\",\n                    \"view\": 1,\n                    \"create\": 0,\n                    \"update\": 0,\n                    \"delete\": 0,\n                },\n            ],\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/user/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p>User not logged in</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unauthorized",
          "content": " HTTP/1.1 401  Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"source\": {\n                \"pointer\": \"Symfony\\\\Component\\\\HttpKernel\\\\Exception\\\\UnauthorizedHttpException\"\n            },\n            \"detail\": \"Token not provided\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/auth/login",
    "title": "Login user",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.0.1",
    "group": "Authentication",
    "name": "Login_user",
    "header": {
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n     \"Accept\":\"application/json\",\n     \"Content-Type\":\"application/json\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"login\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User login email address.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.password",
            "description": "<p>User login password.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Login request:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"login\",\n        \"attributes\": {\n            \"email\": \"test@example.com\",\n            \"password\": \"secret\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.access_token",
            "description": "<p>Access token.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"Bearer\""
            ],
            "optional": false,
            "field": "attributes.token_type",
            "description": "<p>Access token type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.expires_in",
            "description": "<p>Access token expire time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String/null",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.role",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role.id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.role.name",
            "description": "<p>User role name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object/null",
            "optional": false,
            "field": "attributes.color",
            "description": "<p>User color (for Master Users only).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": true,
            "field": "attributes.color.id",
            "description": "<p>User color id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Char",
            "optional": true,
            "field": "attributes.color.value",
            "description": "<p>User color value must be a HEX without # (hashtag).</p>"
          },
          {
            "group": "Success 200",
            "type": "Enum",
            "allowedValues": [
              "\"internal\"",
              "\"external\""
            ],
            "optional": true,
            "field": "attributes.color.type",
            "description": "<p>Driver type (Color depends on Driver type).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.facilities",
            "description": "<p>All Facilities related to the User.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.policies",
            "description": "<p>User policies.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.facility_id",
            "description": "<p>Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.role_id",
            "description": "<p>Role ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.policies.entity",
            "description": "<p>Entity name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.view",
            "description": "<p>View access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.create",
            "description": "<p>Create access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.update",
            "description": "<p>Update access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.policies.delete",
            "description": "<p>Delete access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"id\": \"1\",\n        \"attributes\": {\n            \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\",\n            \"token_type\": \"bearer\",\n            \"expires_in\": 1800,\n            \"first_name\": \"Clark\",\n            \"middle_name\": \"\",\n            \"last_name\": \"Kent\",\n            \"email\": \"sa@journey.test\",\n            \"role\": {\n                \"id\": 1,\n                \"name\": \"Super Admin\"\n            },\n            \"color\": null,\n            \"organization\": {\n                \"id\": null,\n                \"name\": \"\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            },\n            \"facilities\": [],\n            \"policies\": [\n                {\n                    \"id\": 2,\n                    \"facility_id\": 1,\n                    \"role_id\": 6,\n                    \"entity\": \"TransportLog\",\n                    \"view\": 1,\n                    \"create\": 0,\n                    \"update\": 0,\n                    \"delete\": 0,\n                },\n            ]\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/user/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p>Login failed.</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BadRequest",
            "description": "<p>Missing/Wrong api parameters.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unauthorized",
          "content": " HTTP/1.1 401 Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"detail\": \"Unauthorized\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "BadRequest",
          "content": "{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes must contain 2 items.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.password\"\n            },\n            \"detail\": \"The data.attributes.password field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/auth/logout",
    "title": "Log out user",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Authentication",
    "name": "Logout_user",
    "header": {
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Accept\": \"application/json\",\n  \"Authorization\": \"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unauthorized",
            "description": "<p>User not logged in</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Repeated",
            "description": "<p>User multiple logout</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unauthorized",
          "content": " HTTP/1.1 401  Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"source\": {\n                \"pointer\": \"Symfony\\\\Component\\\\HttpKernel\\\\Exception\\\\UnauthorizedHttpException\"\n            },\n            \"detail\": \"Token not provided\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "Repeated",
          "content": " HTTP/1.1 401 Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"source\": {\n                \"pointer\": \"Symfony\\\\Component\\\\HttpKernel\\\\Exception\\\\UnauthorizedHttpException\"\n            },\n            \"detail\": \"The token has been blacklisted\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/AuthController.php",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/auth/reset-password",
    "title": "Reset password",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.0.1",
    "group": "Authentication",
    "name": "Reset_password_using_reset_token",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.token",
            "description": "<p>Reset password token (sent by email)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.password",
            "description": "<p>New password for user</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"attributes\": {\n            \"token\": \"JDJ5JDEwJGh1dThydDguanMxWFZ2NkQwcy4uRU83RHdrYjFXeTk4QjduQ0RqZWQ0cGI3UDRZNUt6Y20u\",\n            \"password\": \"secret\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n {\n    \"data\": null,\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Bad-Request",
            "description": "<p>Wrong token sent.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Bad-Request",
          "content": "HTTP/1.1 400 Bad-Request\n{\n  \"errors\": [\n    {\n      \"status\": \"400\",\n      \"source\": {\n        \"pointer\": \"data.attributes.token\"\n      },\n      \"detail\": \"The selected data.attributes.token is invalid.\"\n    }\n  ]\n}",
          "type": "json"
        },
        {
          "title": "Bad-Request",
          "content": "HTTP/1.1 400 Bad-Request\n{\n   \"errors\": [\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes\"\n           },\n           \"detail\": \"The data.attributes field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.token\"\n           },\n           \"detail\": \"The data.attributes.token field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.password\"\n           },\n           \"detail\": \"The data.attributes.password field is required.\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/ForgotPasswordController.php",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/auth/forgot-password",
    "title": "Get reset token by e-mail",
    "permission": [
      {
        "name": "none"
      }
    ],
    "version": "0.0.1",
    "group": "Authentication",
    "name": "Send_reset_token_e_mail",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"attributes\": {\n            \"email\": \"jones.greenfield@journey.test\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n {\n    \"data\": null,\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "BadRequest",
            "description": "<p>Missing/Wrong api parameters.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "BadRequest",
          "content": "HTTP/1.1 400 BadRequest\n{\n   \"errors\": [\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes\"\n           },\n           \"detail\": \"The data.attributes field is required.\"\n       },\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.email\"\n           },\n           \"detail\": \"The data.attributes.email field is required.\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Auth/ForgotPasswordController.php",
    "groupTitle": "Authentication"
  },
  {
    "type": "put",
    "url": "/bidding/accept-driver:id",
    "title": "Accept driver on pending event",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Bidding",
    "name": "Accept_driver",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Driver id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/BiddingController.php",
    "groupTitle": "Bidding"
  },
  {
    "type": "post",
    "url": "/bidding/assign-drivers/{event_id}",
    "title": "Assign drivers to an event.",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Bidding",
    "name": "Assign_drivers_to_the_unassigned_event",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.drivers",
            "description": "<p>Event drivers.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "attributes.drivers.etc_id",
            "description": "<p>Driver ETC ID (for external drivers).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "attributes.drivers.user_id",
            "description": "<p>Driver User ID (for internal drivers).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "attributes.drivers.name",
            "description": "<p>Driver name (for unregistered drivers).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "attributes.drivers.emails",
            "description": "<p>Driver (for unregistered drivers).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\":{\n        \"type\":\"events\",\n        \"attributes\":{\n            \"status\":\"internal\",\n            \"drivers\":[\n                {\n                    \"user_id\":1,\n                }\n            ],\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.description",
            "description": "<p>Event description.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Event Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Event name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers",
            "description": "<p>Passengers data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.id",
            "description": "<p>Passenger ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.client_id",
            "description": "<p>Passenger Client ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.name",
            "description": "<p>Passenger name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.room_number",
            "description": "<p>Passenger room #.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments",
            "description": "<p>Passenger Appointments data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.id",
            "description": "<p>Appointment ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.time",
            "description": "<p>Appointment time.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments.location",
            "description": "<p>Appointment Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.recurrences",
            "description": "<p>Event recurrences.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.date",
            "description": "<p>Recurrence date.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.start_time",
            "description": "<p>Recurrence start time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.end_time",
            "description": "<p>Recurrence end time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.rrule",
            "description": "<p>Recurrence rule (format = RFC 2445 / RRULE).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.user",
            "description": "<p>Event User (creator) data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.user.id",
            "description": "<p>Event User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.email",
            "description": "<p>Event User email id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.first_name",
            "description": "<p>Event User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.middle_name",
            "description": "<p>Event User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.last_name",
            "description": "<p>Event User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.drivers",
            "description": "<p>Drivers data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.drivers.id",
            "description": "<p>Driver ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.drivers.etc_id",
            "description": "<p>Driver ETC ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.drivers.user_id",
            "description": "<p>Driver User ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.drivers.status",
            "description": "<p>Driver status.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.drivers.name",
            "description": "<p>Driver name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.drivers.emails",
            "description": "<p>Driver emails.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\":\"events\",\n            \"id\":\"1\",\n            \"attributes\":{\n                \"name\":\"Ann goes to the Dentist\",\n                \"date\":\"2018-05-05\",\n                \"start_time\":\"04:05:50\",\n                \"end_time\":\"08:06:46\",\n                \"rrule\":null,\n                \"recurrences\":[\n                    {\n                        \"date\":\"2018-05-05\",\n                        \"start_time\":\"04:05:50\",\n                        \"end_time\":\"08:06:46\"\n                    }\n                ],\n                \"transport_type\":\"ambulatory\",\n                \"transportation_type\":\"external\",\n                \"description\":\"\",\n                \"user\":{\n                    \"id\":4,\n                    \"first_name\":\"Sylvia\",\n                    \"middle_name\":\"Silver\",\n                    \"last_name\":\"Pine\",\n                    \"email\":\"fa@silverpine.test\"\n                },\n                \"facility_id\":1,\n                \"location\":{\n                    \"id\":1,\n                    \"name\":\"Lynch, Kunde and Dach\",\n                    \"phone\":\"+1 (374) 561-2164\",\n                    \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                    \"city\":\"Ferryborough\",\n                    \"state\":\"CA\",\n                    \"postcode\":\"23692-3371\",\n                    \"facility_id\":1\n                },\n                \"passengers\":[\n                    {\n                        \"id\":1,\n                        \"client_id\":null,\n                        \"name\":\"Ann Smith\",\n                        \"room_number\":\"A113\",\n                        \"appointments\":[\n                            {\n                                \"id\":1,\n                                \"time\":\"10:00:00\",\n                                \"location\":{\n                                    \"id\":1,\n                                    \"name\":\"Lynch, Kunde and Dach\",\n                                    \"phone\":\"+1 (374) 561-2164\",\n                                    \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                                    \"city\":\"Ferryborough\",\n                                    \"state\":\"CA\",\n                                    \"postcode\":\"23692-3371\",\n                                    \"facility_id\":1\n                                }\n                            }\n                        ]\n                    }\n                ],\n                \"drivers\":[\n                    {\n                        \"id\":1,\n                        \"etc_id\":null,\n                        \"user_id\":1,\n                        \"status\":\"accepted\",\n                        \"name\":\"Peter Parker\",\n                        \"emails\":\"peterparker@spiderman.test\",\n                    }\n                ]\n            },\n            \"links\":{\n                \"self\":\"http://api.journey.local/events/1\"\n            }\n        },\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/BiddingController.php",
    "groupTitle": "Bidding"
  },
  {
    "type": "delete",
    "url": "/bidding/decline-all-drivers:event_id",
    "title": "Unassign all driver from specified event",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Bidding",
    "name": "Unassign_event_drivers",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "event_id",
            "description": "<p>Event id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/BiddingController.php",
    "groupTitle": "Bidding"
  },
  {
    "type": "put",
    "url": "/bidding/update-fee:id",
    "title": "Update accepted driver fee",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Bidding",
    "name": "Update_accepted_driver_fee",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Driver id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"drivers\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.fee",
            "description": "<p>Accepted driver fee.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\":{\n        \"type\":\"drivers\",\n        \"attributes\":{\n            \"fee\": 15.5,\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/BiddingController.php",
    "groupTitle": "Bidding"
  },
  {
    "type": "post",
    "url": "/clients",
    "title": "Add new client",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Clients",
    "name": "Add_new_client",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"clients\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>Client first name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>Client middle name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>Client last name.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.room_number",
            "description": "<p>Client room number.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.responsible_party_email",
            "description": "<p>Client Responsible Party email.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Client facility id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"clients\",\n        \"attributes\": {\n            \"first_name\": \"Betty\",\n            \"middle_name\": \"Mohr\",\n            \"last_name\": \"Kautzer\",\n            \"room_number\": 19,\n            \"responsible_party_email\": \"betty.junior@gmail.test\",\n            \"facility_id\": 2\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"clients\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>Client first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>Client middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>Client last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.responsible_party_email",
            "description": "<p>Client Responsible Party email.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.room_number",
            "description": "<p>Client room number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Client facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"clients\",\n        \"id\": \"8\",\n        \"attributes\": {\n            \"first_name\": \"Betty\",\n            \"middle_name\": \"Mohr\",\n            \"last_name\": \"Kautzer\",\n            \"room_number\": 19,\n            \"responsible_party_email\": \"betty.junior@gmail.test\",\n            \"facility_id\": 2\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/clients/8\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes must contain 6 items.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.room_number\"\n            },\n            \"detail\": \"The data.attributes.room_number field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Client/ClientController.php",
    "groupTitle": "Clients"
  },
  {
    "type": "delete",
    "url": "/clients/:id",
    "title": "Delete client",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Clients",
    "name": "Delete_client",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Client/ClientController.php",
    "groupTitle": "Clients"
  },
  {
    "type": "get",
    "url": "/clients",
    "title": "Get client list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "1.6.0",
    "group": "Clients",
    "name": "Get_client_list__filterable_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "facility_id",
            "description": "<p>Filter by facility id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"first_name\"",
              "\"room_number\"",
              "\"responsible_party_email\""
            ],
            "optional": true,
            "field": "order_by",
            "description": "<p>Ordering column name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"ASC\"",
              "\"DESC\""
            ],
            "optional": true,
            "field": "order",
            "description": "<p>Ordering direction. (case-insensitive)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>If sent can paginate the list and receive a meta data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"clients\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>Client first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>Client middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>Client last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.room_number",
            "description": "<p>Client room number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.responsible_party_email",
            "description": "<p>Client Responsible Party email.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Client facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_status",
            "description": "<p>Transport status: &quot;on&quot; or &quot;off&quot;.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.ongoing_event",
            "description": "<p>Ongoing Event or NULL.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta",
            "description": "<p>Only if sent a page GET parameter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta.pagination",
            "description": "<p>Contains a data for pagination</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"clients\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"first_name\": \"Anika\",\n                \"middle_name\": \"Mayert\",\n                \"last_name\": \"Willms\",\n                \"room_number\": 34,\n                \"responsible_party_email\": \"anika.junior@gmail.test\",\n                \"facility_id\": 1,\n                \"transport_status\": \"off\",\n                \"ongoing_event\": null,\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/clients/1\"\n            }\n        },\n        {\n            \"type\": \"clients\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"first_name\": \"Kurtis\",\n                \"middle_name\": \"Lakin\",\n                \"last_name\": \"Bailey\",\n                \"room_number\": 6,\n                \"responsible_party_email\": \"kurtis.junior@gmail.test\",\n                \"facility_id\": 1,\n                \"transport_status\": \"off\",\n                \"ongoing_event\": null,\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/clients/2\"\n            }\n        },\n        {\n            \"type\": \"clients\",\n            \"id\": \"3\",\n            \"attributes\": {\n                \"first_name\": \"Betty\",\n                \"middle_name\": \"Mohr\",\n                \"last_name\": \"Kautzer\",\n                \"room_number\": 19,\n                \"responsible_party_email\": \"betty.junior@gmail.test\",\n                \"facility_id\": 2,\n                \"transport_status\": \"off\",\n                \"ongoing_event\": {\n                    \"id\": 5,\n                    \"name\": \"Damion goes to the Dentist\",\n                    \"date\": \"2018-05-25\",\n                    \"start_time\": \"12:46:03\",\n                    \"end_time\": \"05:58:35\",\n                    \"transport_type\": \"passenger\",\n                    \"transportation_type\": \"2\",\n                    \"description\": \"\",\n                    \"user\": {\n                         \"id\": 4,\n                         \"email\": \"fa@silverpine.test\",\n                         \"first_name\": \"Sylvia\",\n                         \"middle_name\": \"Silver\",\n                         \"last_name\": \"Pine\"\n                     },\n                    \"facility_id\": 1\n                },\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/clients/3\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Client/ClientController.php",
    "groupTitle": "Clients"
  },
  {
    "type": "get",
    "url": "/clients/:id",
    "title": "Get client by ID",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Clients",
    "name": "Get_specified_client",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"clients\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>Client first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>Client middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>Client last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.room_number",
            "description": "<p>Client room number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.responsible_party_email",
            "description": "<p>Client Responsible Party email.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Client facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"clients\",\n        \"id\": \"8\",\n        \"attributes\": {\n            \"first_name\": \"Betty\",\n            \"middle_name\": \"Mohr\",\n            \"last_name\": \"Kautzer\",\n            \"room_number\": 19,\n            \"responsible_party_email\": \"betty.junior@gmail.test\",\n            \"facility_id\": 2\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/clients/8\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Client/ClientController.php",
    "groupTitle": "Clients"
  },
  {
    "type": "put/patch",
    "url": "/clients/:id",
    "title": "Update client",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Clients",
    "name": "Update_client",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"clients\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>Client first name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>Client middle name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>Client last name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.responsible_party_email",
            "description": "<p>Client Responsible Party email.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.room_number",
            "description": "<p>Client room number.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"clients\",\n        \"attributes\": {\n            \"first_name\": \"Betty\",\n            \"middle_name\": \"Mohr\",\n            \"last_name\": \"Kautzer\",\n            \"responsible_party_email\": \"betty.junior@gmail.test\",\n            \"room_number\": 23\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"clients\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Client id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>Client first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>Client middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>Client last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.room_number",
            "description": "<p>Client room number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.responsible_party_email",
            "description": "<p>Client Responsible Party email.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Client facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"clients\",\n        \"id\": \"8\",\n        \"attributes\": {\n            \"first_name\": \"Betty\",\n            \"middle_name\": \"Mohr\",\n            \"last_name\": \"Kautzer\",\n            \"room_number\": 23,\n            \"responsible_party_email\": \"betty.junior@gmail.test\",\n            \"facility_id\": 2\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/clients/8\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes must contain 6 items.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.room_number\"\n            },\n            \"detail\": \"The data.attributes.room_number field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Client/ClientController.php",
    "groupTitle": "Clients"
  },
  {
    "type": "get",
    "url": "/config",
    "title": "Get config data",
    "version": "0.0.1",
    "group": "Configuration",
    "name": "Get_config_data",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"frontend\":{\n        \"apiEndpoint\":\"http:\\/\\/api.journey.local\\/api\\/\"\n    },\n    \"roles\":{\n        \"Super Admin\":1,\n        \"Organization Admin\":2,\n        \"Upper Management\":3,\n        \"Facility Admin\":4,\n        \"Master User\":5,\n        \"Administrator\":6\n    },\n    \"equipment\":{\n        \"ambulatory\":\"Ambulatory\",\n        \"stretcher\":\"Stretcher\",\n        \"wheelchair\":\"Wheelchair\"\n    },\n    \"colors\":{\n        \"1\":{\n            \"value\":\"FFE0B2\",\n            \"type\":\"internal\"\n        },\n        \"2\":{\n            \"value\":\"FFCC80\",\n            \"type\":\"internal\"\n        },\n        \"3\":{\n            \"value\":\"FFB74D\",\n            \"type\":\"internal\"\n        },\n        \"4\":{\n            \"value\":\"FFA726\",\n            \"type\":\"internal\"\n        },\n        \"5\":{\n            \"value\":\"FF9800\",\n            \"type\":\"internal\"\n        },\n        \"6\":{\n            \"value\":\"FB8C00\",\n            \"type\":\"internal\"\n        },\n        \"7\":{\n            \"value\":\"F57C00\",\n            \"type\":\"internal\"\n        },\n        \"8\":{\n            \"value\":\"EF6C00\",\n            \"type\":\"internal\"\n        },\n        \"9\":{\n            \"value\":\"d7ccc8\",\n            \"type\":\"external\"\n        },\n        \"10\":{\n            \"value\":\"bcaaa4\",\n            \"type\":\"external\"\n        },\n        \"11\":{\n            \"value\":\"a1887f\",\n            \"type\":\"external\"\n        },\n        \"12\":{\n            \"value\":\"8d6e63\",\n            \"type\":\"external\"\n        },\n        \"13\":{\n            \"value\":\"795548\",\n            \"type\":\"external\"\n        },\n        \"14\":{\n            \"value\":\"6d4c41\",\n            \"type\":\"external\"\n        },\n        \"15\":{\n            \"value\":\"5d4037\",\n            \"type\":\"external\"\n        },\n        \"16\":{\n            \"value\":\"4e342e\",\n            \"type\":\"external\"\n        }\n    },\n    \"transport_type\":{\n        \"ambulatory\":\"Ambulatory\",\n        \"stretcher\":\"Stretcher\",\n        \"wheelchair\":\"Wheelchair\",\n        \"passenger\":\"Passenger\"\n    },\n    \"transportation_type\":{\n        \"internal\":\"Internal\",\n        \"external\":\"External\"\n    },\n    \"timezones\":[\n        \"America/Adak\",\n        \"America/Anchorage\",\n        \"America/Anguilla\",\n        \"America/Antigua\",\n        \"America/Araguaina\",\n        \"America/Argentina/Buenos_Aires\",\n        \"America/Argentina/Catamarca\",\n        \"America/Argentina/Cordoba\",\n        \"America/Argentina/Jujuy\",\n        \"America/Argentina/La_Rioja\",\n        \"America/Argentina/Mendoza\",\n        \"America/Argentina/Rio_Gallegos\",\n        \"America/Argentina/Salta\",\n        \"America/Argentina/San_Juan\",\n        \"America/Argentina/San_Luis\",\n        \"America/Argentina/Tucuman\",\n        \"America/Argentina/Ushuaia\",\n        \"America/Aruba\",\n        \"America/Asuncion\",\n        \"America/Atikokan\",\n        \"America/Bahia\",\n        \"America/Bahia_Banderas\",\n        \"America/Barbados\",\n        \"America/Belem\",\n        \"America/Belize\",\n        \"America/Blanc-Sablon\",\n        \"America/Boa_Vista\",\n        \"America/Bogota\",\n        \"America/Boise\",\n        \"America/Cambridge_Bay\",\n        \"America/Campo_Grande\",\n        \"America/Cancun\",\n        \"America/Caracas\",\n        \"America/Cayenne\",\n        \"America/Cayman\",\n        \"America/Chicago\",\n        \"America/Chihuahua\",\n        \"America/Costa_Rica\",\n        \"America/Creston\",\n        \"America/Cuiaba\",\n        \"America/Curacao\",\n        \"America/Danmarkshavn\",\n        \"America/Dawson\",\n        \"America/Dawson_Creek\",\n        \"America/Denver\",\n        \"America/Detroit\",\n        \"America/Dominica\",\n        \"America/Edmonton\",\n        \"America/Eirunepe\",\n        \"America/El_Salvador\",\n        \"America/Fort_Nelson\",\n        \"America/Fortaleza\",\n        \"America/Glace_Bay\",\n        \"America/Godthab\",\n        \"America/Goose_Bay\",\n        \"America/Grand_Turk\",\n        \"America/Grenada\",\n        \"America/Guadeloupe\",\n        \"America/Guatemala\",\n        \"America/Guayaquil\",\n        \"America/Guyana\",\n        \"America/Halifax\",\n        \"America/Havana\",\n        \"America/Hermosillo\",\n        \"America/Indiana/Indianapolis\",\n        \"America/Indiana/Knox\",\n        \"America/Indiana/Marengo\",\n        \"America/Indiana/Petersburg\",\n        \"America/Indiana/Tell_City\",\n        \"America/Indiana/Vevay\",\n        \"America/Indiana/Vincennes\",\n        \"America/Indiana/Winamac\",\n        \"America/Inuvik\",\n        \"America/Iqaluit\",\n        \"America/Jamaica\",\n        \"America/Juneau\",\n        \"America/Kentucky/Louisville\",\n        \"America/Kentucky/Monticello\",\n        \"America/Kralendijk\",\n        \"America/La_Paz\",\n        \"America/Lima\",\n        \"America/Los_Angeles\",\n        \"America/Lower_Princes\",\n        \"America/Maceio\",\n        \"America/Managua\",\n        \"America/Manaus\",\n        \"America/Marigot\",\n        \"America/Martinique\",\n        \"America/Matamoros\",\n        \"America/Mazatlan\",\n        \"America/Menominee\",\n        \"America/Merida\",\n        \"America/Metlakatla\",\n        \"America/Mexico_City\",\n        \"America/Miquelon\",\n        \"America/Moncton\",\n        \"America/Monterrey\",\n        \"America/Montevideo\",\n        \"America/Montserrat\",\n        \"America/Nassau\",\n        \"America/New_York\",\n        \"America/Nipigon\",\n        \"America/Nome\",\n        \"America/Noronha\",\n        \"America/North_Dakota/Beulah\",\n        \"America/North_Dakota/Center\",\n        \"America/North_Dakota/New_Salem\",\n        \"America/Ojinaga\",\n        \"America/Panama\",\n        \"America/Pangnirtung\",\n        \"America/Paramaribo\",\n        \"America/Phoenix\",\n        \"America/Port-au-Prince\",\n        \"America/Port_of_Spain\",\n        \"America/Porto_Velho\",\n        \"America/Puerto_Rico\",\n        \"America/Punta_Arenas\",\n        \"America/Rainy_River\",\n        \"America/Rankin_Inlet\",\n        \"America/Recife\",\n        \"America/Regina\",\n        \"America/Resolute\",\n        \"America/Rio_Branco\",\n        \"America/Santarem\",\n        \"America/Santiago\",\n        \"America/Santo_Domingo\",\n        \"America/Sao_Paulo\",\n        \"America/Scoresbysund\",\n        \"America/Sitka\",\n        \"America/St_Barthelemy\",\n        \"America/St_Johns\",\n        \"America/St_Kitts\",\n        \"America/St_Lucia\",\n        \"America/St_Thomas\",\n        \"America/St_Vincent\",\n        \"America/Swift_Current\",\n        \"America/Tegucigalpa\",\n        \"America/Thule\",\n        \"America/Thunder_Bay\",\n        \"America/Tijuana\",\n        \"America/Toronto\",\n        \"America/Tortola\",\n        \"America/Vancouver\",\n        \"America/Whitehorse\",\n        \"America/Winnipeg\",\n        \"America/Yakutat\",\n        \"America/Yellowknife\"\n    ],\n    \"jwt\": {\n        \"ttl\": 30\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Config/ConfigController.php",
    "groupTitle": "Configuration"
  },
  {
    "type": "post",
    "url": "/etcs",
    "title": "Add new E.T.C.",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "E_T_C_s",
    "name": "Add_new_E_T_C_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"etcs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>E.T.C. name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>Color id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.emails",
            "description": "<p>comma separated email list.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>E.T.C. phone Number.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n    {\n      \"data\": {\n        \"type\": \"etc\",\n        \"attributes\": {\n          \"name\": \"Prof. Moriah Considine\",\n          \"color_id\": 9,\n          \"emails\": \"king.cronin@hotmail.com,vivien.mckenzie@carter.biz,timmothy.treutel@schuster.com\",\n          \"phone\": \"(800) 470 2565\",\n          \"location_id\": 5,\n          \"facility_id\": 4\n        }\n      }\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"etcs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>E.T.C. name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>Color id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.emails",
            "description": "<p>comma separated email list.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>E.T.C. phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Location details.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n       {\n            \"type\": \"etcs\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Ashlee Carter\",\n                \"color_id\": 9,\n                \"emails\": \"rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com\",\n                \"phone\": \"(855) 943-8060\",\n                \"location_id\": 5,\n                \"facility_id\": 4,\n                \"location\": {\n                  \"id\": 5,\n                  \"name\": \"Berge, Greenholt and Harris\",\n                  \"phone\": \"328-486-8780\",\n                  \"address\": \"79929 Junior Cove\\nSouth Ayla, AK 76297\",\n                  \"city\": \"Port Rhett\",\n                  \"state\": \"CA\",\n                  \"postcode\": \"38810\",\n                  \"facility_id\": 4\n                }\n              },\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/etcs/1\"\n            }\n        },\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.name\"\n            },\n            \"detail\": \"The data.attributes.name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.emails\"\n            },\n            \"detail\": \"The data.attributes.emails field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.color_id\"\n            },\n            \"detail\": \"The data.attributes.color_id field is required.\"\n        },\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/ETC/ETCController.php",
    "groupTitle": "E_T_C_s"
  },
  {
    "type": "delete",
    "url": "/etcs/:id",
    "title": "Delete E.T.C.",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "E_T_C_s",
    "name": "Delete_E_T_C_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>E.T.C. id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/ETC/ETCController.php",
    "groupTitle": "E_T_C_s"
  },
  {
    "type": "get",
    "url": "/etcs",
    "title": "Get E.T.C.s list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "1.6.0",
    "group": "E_T_C_s",
    "name": "Get_E_T_C__list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "facility_id",
            "description": "<p>Facility id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"first_name\"",
              "\"room_number\"",
              "\"responsible_party_email\""
            ],
            "optional": true,
            "field": "order_by",
            "description": "<p>Ordering column name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"ASC\"",
              "\"DESC\""
            ],
            "optional": true,
            "field": "order",
            "description": "<p>Ordering direction. (case-insensitive)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>If sent can paginate the list and receive a meta data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"etcs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>E.T.C. name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>Color id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.emails",
            "description": "<p>comma separated email list.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>E.T.C. phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Location details.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta",
            "description": "<p>Only if sent a page GET parameter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta.pagination",
            "description": "<p>Contains a data for pagination</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"etcs\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Ashlee Carter\",\n                \"color_id\": 9,\n                \"emails\": \"rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com\",\n                \"phone\": \"(855) 943-8060\",\n                \"location_id\": 5,\n                \"facility_id\": 4,\n                \"location\": {\n                  \"id\": 5,\n                  \"name\": \"Berge, Greenholt and Harris\",\n                  \"phone\": \"328-486-8780\",\n                  \"address\": \"79929 Junior Cove\\nSouth Ayla, AK 76297\",\n                  \"city\": \"Port Rhett\",\n                  \"state\": \"CA\",\n                  \"postcode\": \"38810\",\n                  \"facility_id\": 4\n                }\n              },\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/etcs/1\"\n            }\n        },\n        {\n            \"type\": \"etcs\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"name\": \"Ashlee Carter\",\n                \"color_id\": 9,\n                \"emails\": \"rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com\",\n                \"phone\": \"(855) 943-8060\",\n                \"location_id\": 5,\n                \"facility_id\": 4,\n                \"location\": {\n                  \"id\": 5,\n                  \"name\": \"Berge, Greenholt and Harris\",\n                  \"phone\": \"328-486-8780\",\n                  \"address\": \"79929 Junior Cove\\nSouth Ayla, AK 76297\",\n                  \"city\": \"Port Rhett\",\n                  \"state\": \"CA\",\n                  \"postcode\": \"38810\",\n                  \"facility_id\": 4\n                }\n              },\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/etcs/2\"\n            }\n        },\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/ETC/ETCController.php",
    "groupTitle": "E_T_C_s"
  },
  {
    "type": "get",
    "url": "/etcs/:id",
    "title": "Get E.T.C. by ID",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "E_T_C_s",
    "name": "Get_specified_E_T_C_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>E.T.C id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"etcs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>E.T.C. name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>Color id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.emails",
            "description": "<p>comma separated email list.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>E.T.C. phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Location details.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n       {\n            \"type\": \"etcs\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Ashlee Carter\",\n                \"color_id\": 9,\n                \"emails\": \"rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com\",\n                \"phone\": \"(855) 943-8060\",\n                \"location_id\": 5,\n                \"facility_id\": 4,\n                \"location\": {\n                  \"id\": 5,\n                  \"name\": \"Berge, Greenholt and Harris\",\n                  \"phone\": \"328-486-8780\",\n                  \"address\": \"79929 Junior Cove\\nSouth Ayla, AK 76297\",\n                  \"city\": \"Port Rhett\",\n                  \"state\": \"CA\",\n                  \"postcode\": \"38810\",\n                  \"facility_id\": 4\n                }\n              },\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/etcs/1\"\n            }\n        },\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/ETC/ETCController.php",
    "groupTitle": "E_T_C_s"
  },
  {
    "type": "put/patch",
    "url": "/etcs/:id",
    "title": "Update E.T.C.",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "E_T_C_s",
    "name": "Update_E_T_C_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"etcs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>E.T.C. name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>Color id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.emails",
            "description": "<p>comma separated email list.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>E.T.C. phone Number.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n    {\n      \"data\": {\n        \"type\": \"etc\",\n        \"attributes\": {\n          \"name\": \"Prof. Moriah Considine\",\n          \"color_id\": 9,\n          \"emails\": \"king.cronin@hotmail.com,vivien.mckenzie@carter.biz,timmothy.treutel@schuster.com\",\n          \"phone\": \"(800) 470 2565\",\n          \"location_id\": 5,\n          \"facility_id\": 4\n        }\n      }\n    }",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"etcs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>E.T.C. name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>Color id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.emails",
            "description": "<p>comma separated email list.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>E.T.C. phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Location details.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n       {\n            \"type\": \"etcs\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Ashlee Carter\",\n                \"color_id\": 9,\n                \"emails\": \"rohan.ahmad@yahoo.com,mayert.damaris@hotmail.com,purdy.audie@tillman.com\",\n                \"phone\": \"(855) 943-8060\",\n                \"location_id\": 5,\n                \"facility_id\": 4,\n                \"location\": {\n                  \"id\": 5,\n                  \"name\": \"Berge, Greenholt and Harris\",\n                  \"phone\": \"328-486-8780\",\n                  \"address\": \"79929 Junior Cove\\nSouth Ayla, AK 76297\",\n                  \"city\": \"Port Rhett\",\n                  \"state\": \"CA\",\n                  \"postcode\": \"38810\",\n                  \"facility_id\": 4\n                }\n              },\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/etcs/1\"\n            }\n        },\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.name\"\n            },\n            \"detail\": \"The data.attributes.name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.emails\"\n            },\n            \"detail\": \"The data.attributes.emails field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.color_id\"\n            },\n            \"detail\": \"The data.attributes.color_id field is required.\"\n        },\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/ETC/ETCController.php",
    "groupTitle": "E_T_C_s"
  },
  {
    "type": "post",
    "url": "/events",
    "title": "Add new event",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Events",
    "name": "Add_new_event",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "attributes.description",
            "description": "<p>Event description.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event Facility ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Event Location ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Event name.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers",
            "description": "<p>Passengers data.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.id",
            "description": "<p>Passenger ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.client_id",
            "description": "<p>Passenger Client ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.name",
            "description": "<p>Passenger name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.room_number",
            "description": "<p>Passenger room #.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers.appointments",
            "description": "<p>Passenger Appointments data.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.id",
            "description": "<p>Appointment ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.time",
            "description": "<p>Appointment time.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments.location_id",
            "description": "<p>Appointment Location ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.rrule",
            "description": "<p>Recurrence rule (format = RFC 2445 / RRULE).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\":{\n        \"type\":\"events\",\n        \"attributes\":{\n            \"name\":\"Ann goes to the Dentist\",\n            \"passengers\":[\n                {\n                    \"id\":1,\n                    \"client_id\":null,\n                    \"name\":\"Ann Smith\",\n                    \"room_number\":\"A113\",\n                    \"appointments\":[\n                        {\n                            \"id\":1,\n                            \"time\":\"10:00:00\",\n                            \"location_id\":1\n                        }\n                    ]\n                }\n            ],\n            \"date\":\"2018-05-05\",\n            \"start_time\":\"04:05:50\",\n            \"end_time\":\"08:06:46\",\n            \"rrule\":null,\n            \"transport_type\":\"ambulatory\",\n            \"description\":\"\",\n            \"location_id\":1\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.description",
            "description": "<p>Event description.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Event Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Event name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers",
            "description": "<p>Passengers data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.id",
            "description": "<p>Passenger ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.client_id",
            "description": "<p>Passenger Client ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.name",
            "description": "<p>Passenger name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.room_number",
            "description": "<p>Passenger room #.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers.appointments",
            "description": "<p>Passenger Appointments data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.id",
            "description": "<p>Appointment ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.time",
            "description": "<p>Appointment time.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments.location",
            "description": "<p>Appointment Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.recurrences",
            "description": "<p>Event recurrences.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.date",
            "description": "<p>Recurrence date.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.start_time",
            "description": "<p>Recurrence start time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.end_time",
            "description": "<p>Recurrence end time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.rrule",
            "description": "<p>Recurrence rule (format = RFC 2445 / RRULE).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.user",
            "description": "<p>Event User (creator) data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.user.id",
            "description": "<p>Event User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.email",
            "description": "<p>Event User email id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.first_name",
            "description": "<p>Event User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.middle_name",
            "description": "<p>Event User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.last_name",
            "description": "<p>Event User last name.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\":\"events\",\n        \"id\":\"1\",\n        \"attributes\":{\n            \"name\":\"Ann goes to the Dentist\",\n            \"date\":\"2018-05-05\",\n            \"start_time\":\"04:05:50\",\n            \"end_time\":\"08:06:46\",\n            \"rrule\":null,\n            \"recurrences\":[\n                {\n                    \"date\":\"2018-05-05\",\n                    \"start_time\":\"04:05:50\",\n                    \"end_time\":\"08:06:46\"\n                }\n            ],\n            \"transport_type\":\"ambulatory\",\n            \"transportation_type\":\"external\",\n            \"description\":\"\",\n            \"user\":{\n                \"id\":4,\n                \"first_name\":\"Sylvia\",\n                \"middle_name\":\"Silver\",\n                \"last_name\":\"Pine\",\n                \"email\":\"fa@silverpine.test\"\n            },\n            \"facility_id\":1,\n            \"location\":{\n                \"id\":1,\n                \"name\":\"Lynch, Kunde and Dach\",\n                \"phone\":\"+1 (374) 561-2164\",\n                \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                \"city\":\"Ferryborough\",\n                \"state\":\"CA\",\n                \"postcode\":\"23692-3371\",\n                \"facility_id\":1\n            },\n            \"passengers\":[\n                {\n                    \"id\":1,\n                    \"client_id\":null,\n                    \"name\":\"Ann Smith\",\n                    \"room_number\":\"A113\",\n                    \"appointments\":[\n                        {\n                            \"id\":1,\n                            \"time\":\"10:00:00\",\n                            \"location\":{\n                                \"id\":1,\n                                \"name\":\"Lynch, Kunde and Dach\",\n                                \"phone\":\"+1 (374) 561-2164\",\n                                \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                                \"city\":\"Ferryborough\",\n                                \"state\":\"CA\",\n                                \"postcode\":\"23692-3371\",\n                                \"facility_id\":1\n                            }\n                        }\n                    ]\n                }\n            ]\n        },\n        \"links\":{\n            \"self\":\"http://api.journey.local/events/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": " HTTP/1.1 400 Bad Request\n {\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes must have between 8 and 9 items.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.transportation_type\"\n            },\n            \"detail\": \"The data.attributes.transportation type field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/EventController.php",
    "groupTitle": "Events"
  },
  {
    "type": "delete",
    "url": "/events/:id",
    "title": "Delete event",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Events",
    "name": "Delete_event",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/EventController.php",
    "groupTitle": "Events"
  },
  {
    "type": "get",
    "url": "/events",
    "title": "Get event list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Events",
    "name": "Get_event_list",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.description",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.user",
            "description": "<p>(Owner/Creator).</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.user.id",
            "description": "<p>Event user id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.email",
            "description": "<p>Event user email id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.first_name",
            "description": "<p>Event user first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.middle_name",
            "description": "<p>Event user middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.last_name",
            "description": "<p>Event user last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event facility id (Owner).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"events\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Damion goes to the Dentist\",\n                \"date\": \"2018-05-25\",\n                \"start_time\": \"12:46:03\",\n                \"end_time\": \"05:58:35\",\n                \"transport_type\": \"passenger\",\n                \"transportation_type\": \"2\",\n                \"description\": \"\",\n                \"user\": {\n                     \"id\": 4,\n                     \"email\": \"fa@silverpine.test\",\n                     \"first_name\": \"Sylvia\",\n                     \"middle_name\": \"Silver\",\n                     \"last_name\": \"Pine\"\n                 },\n                \"facility_id\": 1\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/events/1\"\n            }\n        },\n        {\n            \"type\": \"events\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"name\": \"Kelsi goes to the Ambulance\",\n                \"date\": \"2018-05-05\",\n                \"start_time\": \"14:12:33\",\n                \"end_time\": \"05:01:01\",\n                \"transport_type\": \"passenger\",\n                \"transportation_type\": \"1\",\n                \"description\": \"\",\n                \"user\": {\n                     \"id\": 4,\n                     \"email\": \"fa@silverpine.test\",\n                     \"first_name\": \"Sylvia\",\n                     \"middle_name\": \"Silver\",\n                     \"last_name\": \"Pine\"\n                 },\n                \"facility_id\": 1\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/events/2\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/EventController.php",
    "groupTitle": "Events"
  },
  {
    "type": "get",
    "url": "/bidding",
    "title": "Get events of a specific status.",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "1.6.0",
    "group": "Events",
    "name": "Get_events_by_scope_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"unassigned\"",
              "\"pending\"",
              "\"accepted\""
            ],
            "optional": true,
            "field": "status",
            "description": "<p>Filter by event status.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"id\"",
              "\"name\"",
              "\"datetime\""
            ],
            "optional": true,
            "field": "order_by",
            "description": "<p>Ordering column name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"ASC\"",
              "\"DESC\""
            ],
            "optional": true,
            "field": "order",
            "description": "<p>Ordering direction. (case-insensitive)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>If sent can paginate the list and receive a meta data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.description",
            "description": "<p>Event description.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Event Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Event name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers",
            "description": "<p>Passengers data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.id",
            "description": "<p>Passenger ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.client_id",
            "description": "<p>Passenger Client ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.name",
            "description": "<p>Passenger name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.room_number",
            "description": "<p>Passenger room #.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments",
            "description": "<p>Passenger Appointments data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.id",
            "description": "<p>Appointment ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.time",
            "description": "<p>Appointment time.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments.location",
            "description": "<p>Appointment Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.recurrences",
            "description": "<p>Event recurrences.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.date",
            "description": "<p>Recurrence date.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.start_time",
            "description": "<p>Recurrence start time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.end_time",
            "description": "<p>Recurrence end time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.rrule",
            "description": "<p>Recurrence rule (format = RFC 2445 / RRULE).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.user",
            "description": "<p>Event User (creator) data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.user.id",
            "description": "<p>Event User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.email",
            "description": "<p>Event User email id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.first_name",
            "description": "<p>Event User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.middle_name",
            "description": "<p>Event User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.last_name",
            "description": "<p>Event User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.drivers",
            "description": "<p>Drivers data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.drivers.id",
            "description": "<p>Driver ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.drivers.etc_id",
            "description": "<p>Driver ETC ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.drivers.user_id",
            "description": "<p>Driver User ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.drivers.status",
            "description": "<p>Driver status.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.drivers.name",
            "description": "<p>Driver name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.drivers.emails",
            "description": "<p>Driver emails.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\":\"events\",\n            \"id\":\"1\",\n            \"attributes\":{\n                \"name\":\"Ann goes to the Dentist\",\n                \"date\":\"2018-05-05\",\n                \"start_time\":\"04:05:50\",\n                \"end_time\":\"08:06:46\",\n                \"rrule\":null,\n                \"recurrences\":[\n                    {\n                        \"date\":\"2018-05-05\",\n                        \"start_time\":\"04:05:50\",\n                        \"end_time\":\"08:06:46\"\n                    }\n                ],\n                \"transport_type\":\"ambulatory\",\n                \"transportation_type\":\"external\",\n                \"description\":\"\",\n                \"user\":{\n                    \"id\":4,\n                    \"first_name\":\"Sylvia\",\n                    \"middle_name\":\"Silver\",\n                    \"last_name\":\"Pine\",\n                    \"email\":\"fa@silverpine.test\"\n                },\n                \"facility_id\":1,\n                \"location\":{\n                    \"id\":1,\n                    \"name\":\"Lynch, Kunde and Dach\",\n                    \"phone\":\"+1 (374) 561-2164\",\n                    \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                    \"city\":\"Ferryborough\",\n                    \"state\":\"CA\",\n                    \"postcode\":\"23692-3371\",\n                    \"facility_id\":1\n                },\n                \"passengers\":[\n                    {\n                        \"id\":1,\n                        \"client_id\":null,\n                        \"name\":\"Ann Smith\",\n                        \"room_number\":\"A113\",\n                        \"appointments\":[\n                            {\n                                \"id\":1,\n                                \"time\":\"10:00:00\",\n                                \"location\":{\n                                    \"id\":1,\n                                    \"name\":\"Lynch, Kunde and Dach\",\n                                    \"phone\":\"+1 (374) 561-2164\",\n                                    \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                                    \"city\":\"Ferryborough\",\n                                    \"state\":\"CA\",\n                                    \"postcode\":\"23692-3371\",\n                                    \"facility_id\":1\n                                }\n                            }\n                        ]\n                    }\n                ],\n                \"drivers\":[\n                    {\n                        \"id\":1,\n                        \"etc_id\":null,\n                        \"user_id\":1,\n                        \"status\":\"accepted\",\n                        \"name\":\"Peter Parker\",\n                        \"emails\":\"peterparker@spiderman.test\",\n                    }\n                ]\n            },\n            \"links\":{\n                \"self\":\"http://api.journey.local/events/1\"\n            }\n        },\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/BiddingController.php",
    "groupTitle": "Events"
  },
  {
    "type": "get",
    "url": "/events/:id",
    "title": "Get event by ID",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Events",
    "name": "Get_specified_event",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.description",
            "description": "<p>Event description.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Event Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Event name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers",
            "description": "<p>Passengers data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.id",
            "description": "<p>Passenger ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.client_id",
            "description": "<p>Passenger Client ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.name",
            "description": "<p>Passenger name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.room_number",
            "description": "<p>Passenger room #.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers.appointments",
            "description": "<p>Passenger Appointments data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.id",
            "description": "<p>Appointment ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.time",
            "description": "<p>Appointment time.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments.location",
            "description": "<p>Appointment Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.recurrences",
            "description": "<p>Event recurrences.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.date",
            "description": "<p>Recurrence date.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.start_time",
            "description": "<p>Recurrence start time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.end_time",
            "description": "<p>Recurrence end time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.rrule",
            "description": "<p>Recurrence rule (format = RFC 2445 / RRULE).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.user",
            "description": "<p>Event User (creator) data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.user.id",
            "description": "<p>Event User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.email",
            "description": "<p>Event User email id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.first_name",
            "description": "<p>Event User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.middle_name",
            "description": "<p>Event User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.last_name",
            "description": "<p>Event User last name.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\":\"events\",\n        \"id\":\"1\",\n        \"attributes\":{\n            \"name\":\"Ann goes to the Dentist\",\n            \"date\":\"2018-05-05\",\n            \"start_time\":\"04:05:50\",\n            \"end_time\":\"08:06:46\",\n            \"rrule\":null,\n            \"recurrences\":[\n                {\n                    \"date\":\"2018-05-05\",\n                    \"start_time\":\"04:05:50\",\n                    \"end_time\":\"08:06:46\"\n                }\n            ],\n            \"transport_type\":\"ambulatory\",\n            \"transportation_type\":\"external\",\n            \"description\":\"\",\n            \"user\":{\n                \"id\":4,\n                \"first_name\":\"Sylvia\",\n                \"middle_name\":\"Silver\",\n                \"last_name\":\"Pine\",\n                \"email\":\"fa@silverpine.test\"\n            },\n            \"facility_id\":1,\n            \"location\":{\n                \"id\":1,\n                \"name\":\"Lynch, Kunde and Dach\",\n                \"phone\":\"+1 (374) 561-2164\",\n                \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                \"city\":\"Ferryborough\",\n                \"state\":\"CA\",\n                \"postcode\":\"23692-3371\",\n                \"facility_id\":1\n            },\n            \"passengers\":[\n                {\n                    \"id\":1,\n                    \"client_id\":null,\n                    \"name\":\"Ann Smith\",\n                    \"room_number\":\"A113\",\n                    \"appointments\":[\n                        {\n                            \"id\":1,\n                            \"time\":\"10:00:00\",\n                            \"location\":{\n                                \"id\":1,\n                                \"name\":\"Lynch, Kunde and Dach\",\n                                \"phone\":\"+1 (374) 561-2164\",\n                                \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                                \"city\":\"Ferryborough\",\n                                \"state\":\"CA\",\n                                \"postcode\":\"23692-3371\",\n                                \"facility_id\":1\n                            }\n                        }\n                    ]\n                }\n            ]\n        },\n        \"links\":{\n            \"self\":\"http://api.journey.local/events/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Wrong-id",
            "description": "<p>Get a non-existing resource</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Wrong id",
          "content": "HTTP/1.1 401 Unauthorized\n{\n    \"errors\": [\n        {\n            \"status\": \"401\",\n            \"source\": {\n                \"pointer\": \"Illuminate\\\\Auth\\\\Access\\\\AuthorizationException\"\n            },\n            \"detail\": \"This action is unauthorized.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/EventController.php",
    "groupTitle": "Events"
  },
  {
    "type": "put/patch",
    "url": "/events/:id",
    "title": "Update event",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Events",
    "name": "Update_event",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "attributes.description",
            "description": "<p>Event description.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event Facility ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.location_id",
            "description": "<p>Event Location ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Event name.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers",
            "description": "<p>Passengers data.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.id",
            "description": "<p>Passenger ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.client_id",
            "description": "<p>Passenger Client ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.name",
            "description": "<p>Passenger name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.room_number",
            "description": "<p>Passenger room #.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers.appointments",
            "description": "<p>Passenger Appointments data.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.id",
            "description": "<p>Appointment ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.time",
            "description": "<p>Appointment time.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments.location_id",
            "description": "<p>Appointment Location ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.rrule",
            "description": "<p>Recurrence rule (format = RFC 2445 / RRULE).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\":{\n        \"type\":\"events\",\n        \"attributes\":{\n            \"name\":\"Ann goes to the Dentist\",\n            \"passengers\":[\n                {\n                    \"id\":1,\n                    \"client_id\":null,\n                    \"name\":\"Ann Smith\",\n                    \"room_number\":\"A113\",\n                    \"appointments\":[\n                        {\n                            \"id\":1,\n                            \"time\":\"10:00:00\",\n                            \"location_id\":1\n                        }\n                    ]\n                }\n            ],\n            \"date\":\"2018-05-05\",\n            \"start_time\":\"04:05:50\",\n            \"end_time\":\"08:06:46\",\n            \"rrule\":null,\n            \"transport_type\":\"ambulatory\",\n            \"transportation_type\":\"external\",\n            \"description\":\"\",\n            \"location_id\":1\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"events\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Event id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Event date (format = 'yyyy-mm-dd').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.description",
            "description": "<p>Event description.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.end_time",
            "description": "<p>Event end time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Event Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.location",
            "description": "<p>Event Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Event name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers",
            "description": "<p>Passengers data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.id",
            "description": "<p>Passenger ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.client_id",
            "description": "<p>Passenger Client ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.name",
            "description": "<p>Passenger name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.room_number",
            "description": "<p>Passenger room #.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.passengers.appointments",
            "description": "<p>Passenger Appointments data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.id",
            "description": "<p>Appointment ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.time",
            "description": "<p>Appointment time.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.passengers.appointments.location",
            "description": "<p>Appointment Location.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.passengers.appointments.location.id",
            "description": "<p>Location ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.phone",
            "description": "<p>Location phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.address",
            "description": "<p>Location address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.passengers.appointments.location.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "attributes.recurrences",
            "description": "<p>Event recurrences.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.date",
            "description": "<p>Recurrence date.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.start_time",
            "description": "<p>Recurrence start time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.recurrences.end_time",
            "description": "<p>Recurrence end time.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.rrule",
            "description": "<p>Recurrence rule (format = RFC 2445 / RRULE).</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.start_time",
            "description": "<p>Event start time (format = 'hh:mm:ss').</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Event transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.transportation_type",
            "description": "<p>Event transportation type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.user",
            "description": "<p>Event User (creator) data.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.user.id",
            "description": "<p>Event User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.email",
            "description": "<p>Event User email id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.first_name",
            "description": "<p>Event User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.middle_name",
            "description": "<p>Event User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.user.last_name",
            "description": "<p>Event User last name.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\":\"events\",\n        \"id\":\"1\",\n        \"attributes\":{\n            \"name\":\"Ann goes to the Dentist\",\n            \"date\":\"2018-05-05\",\n            \"start_time\":\"04:05:50\",\n            \"end_time\":\"08:06:46\",\n            \"rrule\":null,\n            \"recurrences\":[\n                {\n                    \"date\":\"2018-05-05\",\n                    \"start_time\":\"04:05:50\",\n                    \"end_time\":\"08:06:46\"\n                }\n            ],\n            \"transport_type\":\"ambulatory\",\n            \"transportation_type\":\"external\",\n            \"description\":\"\",\n            \"user\":{\n                \"id\":4,\n                \"first_name\":\"Sylvia\",\n                \"middle_name\":\"Silver\",\n                \"last_name\":\"Pine\",\n                \"email\":\"fa@silverpine.test\"\n            },\n            \"facility_id\":1,\n            \"location\":{\n                \"id\":1,\n                \"name\":\"Lynch, Kunde and Dach\",\n                \"phone\":\"+1 (374) 561-2164\",\n                \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                \"city\":\"Ferryborough\",\n                \"state\":\"CA\",\n                \"postcode\":\"23692-3371\",\n                \"facility_id\":1\n            },\n            \"passengers\":[\n                {\n                    \"id\":1,\n                    \"client_id\":null,\n                    \"name\":\"Ann Smith\",\n                    \"room_number\":\"A113\",\n                    \"appointments\":[\n                        {\n                            \"id\":1,\n                            \"time\":\"10:00:00\",\n                            \"location\":{\n                                \"id\":1,\n                                \"name\":\"Lynch, Kunde and Dach\",\n                                \"phone\":\"+1 (374) 561-2164\",\n                                \"address\":\"393 Julian Way\\nGottliebtown, DE 75960-9164\",\n                                \"city\":\"Ferryborough\",\n                                \"state\":\"CA\",\n                                \"postcode\":\"23692-3371\",\n                                \"facility_id\":1\n                            }\n                        }\n                    ]\n                }\n            ]\n        },\n        \"links\":{\n            \"self\":\"http://api.journey.local/events/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": " HTTP/1.1 400 Bad Request\n {\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes must have between 8 and 9 items.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.transportation_type\"\n            },\n            \"detail\": \"The data.attributes.transportation type field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Event/EventController.php",
    "groupTitle": "Events"
  },
  {
    "type": "post",
    "url": "/facilities",
    "title": "Add new facility",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Facilities",
    "name": "Add_new_facility",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"facilities\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Facility name.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.organization_id",
            "description": "<p>Parent organization id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"facilities\",\n        \"attributes\": {\n            \"name\": \"Apple Clinics\",\n            \"organization_id\": 1\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"facilities\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.organization_id",
            "description": "<p>Parent organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"facilities\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Evergreen Retirement Home\",\n                \"organization_id\": 1\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/facilities/1\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unique-name",
            "description": "<p>Same name not allowed</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unique name",
          "content": "HTTP/1.1 400 Bad Request\n {\n     \"errors\": [\n         {\n             \"status\": \"400\",\n             \"source\": {\n                 \"pointer\": \"data.attributes.name\"\n             },\n             \"detail\": \"Facility name must be unique.\"\n         }\n     ]\n }",
          "type": "json"
        },
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n {\n     \"errors\": [\n         {\n             \"status\": \"400\",\n             \"source\": {\n                 \"pointer\": \"data.attributes\"\n             },\n             \"detail\": \"The data.attributes field is required.\"\n         },\n         {\n             \"status\": \"400\",\n             \"source\": {\n                 \"pointer\": \"data.attributes.name\"\n             },\n             \"detail\": \"The data.attributes.name field is required.\"\n         }\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/FacilityController.php",
    "groupTitle": "Facilities"
  },
  {
    "type": "delete",
    "url": "/facilities/:id",
    "title": "Delete facility",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Facilities",
    "name": "Delete_facility",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Facility id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/FacilityController.php",
    "groupTitle": "Facilities"
  },
  {
    "type": "get",
    "url": "/facilities",
    "title": "Get facility list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "1.6.0",
    "group": "Facilities",
    "name": "Get_facility_list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "organization_id",
            "description": "<p>Filter facility list by Organization ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"id\"",
              "\"name\""
            ],
            "optional": true,
            "field": "order_by",
            "description": "<p>Ordering column name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"ASC\"",
              "\"DESC\""
            ],
            "optional": true,
            "field": "order",
            "description": "<p>Ordering direction. (case-insensitive)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>If sent can paginate the list and receive a meta data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.organization_id",
            "description": "<p>Parent organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta",
            "description": "<p>Only if sent a page GET parameter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta.pagination",
            "description": "<p>Contains a data for pagination</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"facilities\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Evergreen Retirement Home\",\n                \"organization_id\": 1\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/facilities/1\"\n            }\n        },\n        {\n            \"type\": \"facilities\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"name\": \"Silver Leaves Retirement Home\",\n                \"organization_id\": 1\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/facilities/2\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/FacilityController.php",
    "groupTitle": "Facilities"
  },
  {
    "type": "get",
    "url": "/facilities/:id",
    "title": "Get facility by ID",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Facilities",
    "name": "Get_specified_facility",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Facility id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"facilities\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.organization_id",
            "description": "<p>Parent organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"facilities\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Evergreen Retirement Home\",\n                \"organization_id\": 1\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/facilities/1\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/FacilityController.php",
    "groupTitle": "Facilities"
  },
  {
    "type": "put/patch",
    "url": "/facilities/:id",
    "title": "Update facility",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Facilities",
    "name": "Update_facility",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Facility id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"facilities\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Facility name.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"facilities\",\n        \"attributes\": {\n            \"name\": \"Orange Clinics\",\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"facilities\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.organization_id",
            "description": "<p>Parent organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"facilities\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Silver Leaves Retirement Home\",\n                \"organization_id\": 1\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/facilities/1\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unique-name",
            "description": "<p>Same name not allowed</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unique name",
          "content": "HTTP/1.1 400 Bad Request\n {\n     \"errors\": [\n         {\n             \"status\": \"400\",\n             \"source\": {\n                 \"pointer\": \"data.attributes.name\"\n             },\n             \"detail\": \"Facility name must be unique.\"\n         }\n     ]\n }",
          "type": "json"
        },
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n {\n     \"errors\": [\n         {\n             \"status\": \"400\",\n             \"source\": {\n                 \"pointer\": \"data.attributes\"\n             },\n             \"detail\": \"The data.attributes field is required.\"\n         },\n         {\n             \"status\": \"400\",\n             \"source\": {\n                 \"pointer\": \"data.attributes.name\"\n             },\n             \"detail\": \"The data.attributes.name field is required.\"\n         }\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/FacilityController.php",
    "groupTitle": "Facilities"
  },
  {
    "type": "post",
    "url": "/locations",
    "title": "Add new location",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Locations",
    "name": "Add_new_location",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"locations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>Location phone Number.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.address",
            "description": "<p>Location full address.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.postcode",
            "description": "<p>Location postal code.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"locations\",\n        \"attributes\": {\n            \"name\": \"O'Keefe-Prosacco\",\n            \"phone\": \"(310) 987-1709 x1007\",\n            \"address\": \"9704 Dickens Ranch Apt. 589\\n North Lew, IN 39427\",\n            \"city\": \"North Jadenmouth\",\n            \"state\": \"CA\",\n            \"postcode\": \"06339-6007\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"locations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>Location phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.address",
            "description": "<p>Location full address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"locations\",\n        \"id\": \"5\",\n        \"attributes\": {\n            \"name\": \"O'Keefe-Prosacco\",\n            \"phone\": \"(310) 987-1709 x1007\",\n            \"address\": \"9704 Dickens Ranch Apt. 589\\n North Lew, IN 39427\",\n            \"city\": \"North Jadenmouth\",\n            \"state\": \"CA\",\n            \"postcode\": \"06339-6007\"\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/locations/5\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unique-email",
            "description": "<p>Same email not allowed</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unique email",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.email\"\n            },\n            \"detail\": \"Location email must be unique.\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.name\"\n            },\n            \"detail\": \"The data.attributes.name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.city\"\n            },\n            \"detail\": \"The data.attributes.city field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.state\"\n            },\n            \"detail\": \"The data.attributes.state field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.address\"\n            },\n            \"detail\": \"The data.attributes.address field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.postcode\"\n            },\n            \"detail\": \"The data.attributes.postcode field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Location/LocationController.php",
    "groupTitle": "Locations"
  },
  {
    "type": "delete",
    "url": "/locations/:id",
    "title": "Delete location",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Locations",
    "name": "Delete_location",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Location/LocationController.php",
    "groupTitle": "Locations"
  },
  {
    "type": "get",
    "url": "/locations",
    "title": "Get location list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "1.6.0",
    "group": "Locations",
    "name": "Get_location_list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "facility_id",
            "description": "<p>Filter by facility id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"name\"",
              "\"phone\"",
              "\"address\"",
              "\"city\"",
              "\"state\"",
              "\"postcode\""
            ],
            "optional": true,
            "field": "order_by",
            "description": "<p>Ordering column name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"ASC\"",
              "\"DESC\""
            ],
            "optional": true,
            "field": "order",
            "description": "<p>Ordering direction. (case-insensitive)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>If sent can paginate the list and receive a meta data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"locations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>Location phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.address",
            "description": "<p>Location full address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta",
            "description": "<p>Only if sent a page GET parameter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta.pagination",
            "description": "<p>Contains a data for pagination</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"locations\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Huels Ltd\",\n                \"phone\": \"+1.215.419.2907\",\n                \"address\": \"28523 Emile Vista\\nPort Ryanstad, HI 01638-6705\",\n                \"city\": \"West Everardoshire\",\n                \"state\": \"CA\",\n                \"postcode\": \"50253\"\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/locations/1\"\n            }\n        },\n        {\n            \"type\": \"locations\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"name\": \"Ullrich, Eichmann and Aufderhar\",\n                \"phone\": \"1-307-850-7206\",\n                \"address\": \"824 Arnaldo Meadow Suite 923\\nNorth Gastonland, PA 55879\",\n                \"city\": \"Verlahaven\",\n                \"state\": \"CA\",\n                \"postcode\": \"12719\"\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/locations/2\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Location/LocationController.php",
    "groupTitle": "Locations"
  },
  {
    "type": "get",
    "url": "/locations/:id",
    "title": "Get location by ID",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Locations",
    "name": "Get_specified_location",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"locations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>Location phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.address",
            "description": "<p>Location full address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"locations\",\n        \"id\": \"1\",\n        \"attributes\": {\n            \"name\": \"Huels Ltd\",\n            \"phone\": \"+1.215.419.2907\",\n            \"address\": \"28523 Emile Vista\\nPort Ryanstad, HI 01638-6705\",\n            \"city\": \"West Everardoshire\",\n            \"state\": \"CA\",\n            \"postcode\": \"50253\"\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/locations/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Location/LocationController.php",
    "groupTitle": "Locations"
  },
  {
    "type": "put/patch",
    "url": "/locations/:id",
    "title": "Update location",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Locations",
    "name": "Update_location",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"locations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>Location phone Number.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.address",
            "description": "<p>Location full address.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.postcode",
            "description": "<p>Location postal code.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\":\n        {\n            \"type\": \"locations\",\n            \"attributes\": {\n                \"name\": \"Huels Ltd\",\n                \"phone\": \"+1.215.419.2907\",\n                \"address\": \"28523 Emile Vista\\nPort Ryanstad, HI 01638-6705\",\n                \"city\": \"West Everardoshire\",\n                \"state\": \"CA\",\n                \"postcode\": \"50253\"\n            }\n        }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"locations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Location id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>Location phone Number.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.address",
            "description": "<p>Location full address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.city",
            "description": "<p>Location city name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.state",
            "description": "<p>Location state code.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.postcode",
            "description": "<p>Location postal code.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"locations\",\n        \"id\": \"1\",\n        \"attributes\": {\n            \"name\": \"Huels Ltd\",\n            \"phone\": \"+1.215.419.2907\",\n            \"address\": \"28523 Emile Vista\\nPort Ryanstad, HI 01638-6705\",\n            \"city\": \"West Everardoshire\",\n            \"state\": \"CA\",\n            \"postcode\": \"50253\"\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/locations/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.name\"\n            },\n            \"detail\": \"The data.attributes.name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.city\"\n            },\n            \"detail\": \"The data.attributes.city field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.state\"\n            },\n            \"detail\": \"The data.attributes.state field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.address\"\n            },\n            \"detail\": \"The data.attributes.address field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.postcode\"\n            },\n            \"detail\": \"The data.attributes.postcode field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Location/LocationController.php",
    "groupTitle": "Locations"
  },
  {
    "type": "post",
    "url": "/organizations",
    "title": "Add new organization",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Organizations",
    "name": "Add_new_organization",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"organizations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Organization name.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"organizations\",\n        \"attributes\": {\n            \"name\": \"Orange Clinics\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"organizations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Organization id</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_limit",
            "description": "<p>Facility limit.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"organizations\",\n        \"id\": \"3\",\n        \"attributes\": {\n            \"name\": \"Orange Clinics\",\n            \"facility_limit\": 2\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/organizations/3\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unique-organization",
            "description": "<p>Same name not allowed</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unique name",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.name\"\n            },\n            \"detail\": \"Organization name must be unique.\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.name\"\n            },\n            \"detail\": \"The data.attributes.name field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/OrganizationController.php",
    "groupTitle": "Organizations"
  },
  {
    "type": "delete",
    "url": "/organizations/:id",
    "title": "Delete Organization",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Organizations",
    "name": "Delete_organization",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Organization id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/OrganizationController.php",
    "groupTitle": "Organizations"
  },
  {
    "type": "get",
    "url": "/organizations",
    "title": "Get organization list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "1.6.0",
    "group": "Organizations",
    "name": "Get_organization_list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"id\"",
              "\"name\""
            ],
            "optional": true,
            "field": "order_by",
            "description": "<p>Ordering column name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"ASC\"",
              "\"DESC\""
            ],
            "optional": true,
            "field": "order",
            "description": "<p>Ordering direction. (case-insensitive)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>If sent can paginate the list and receive a meta data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"organizations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Organization id</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_limit",
            "description": "<p>Facility limit.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta",
            "description": "<p>Only if sent a page GET parameter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta.pagination",
            "description": "<p>Contains a data for pagination</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"organizations\",\n            \"id\": \"3\",\n            \"attributes\": {\n                \"name\": \"Orange Clinics\"\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/organizations/3\"\n            }\n        },\n        {\n            \"type\": \"organizations\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"name\": \"Golden Years Inc.\",\n                \"facility_limit: 2\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/organizations/2\"\n            }\n        },\n        {\n            \"type\": \"organizations\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"name\": \"Silver Pine Ltd.\",\n                \"facility_limit: 2\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/organizations/1\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/OrganizationController.php",
    "groupTitle": "Organizations"
  },
  {
    "type": "get",
    "url": "/organizations/:id",
    "title": "Get organization by ID",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Organizations",
    "name": "Get_specified_organization",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Organization id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"organizations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Organization id</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_limit",
            "description": "<p>Facility limit.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"organizations\",\n        \"id\": \"1\",\n        \"attributes\": {\n            \"name\": \"Silver Pine Ltd.\",\n            \"facility_limit: 2\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/organizations/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/OrganizationController.php",
    "groupTitle": "Organizations"
  },
  {
    "type": "put/patch",
    "url": "/organizations/:id",
    "title": "Update organization",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Organizations",
    "name": "Update_organization",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Organization id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"organizations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Organization name.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_limit",
            "description": "<p>Facility limit.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"organizations\",\n        \"attributes\": {\n            \"name\": \"Apple Clinics\",\n            \"facility_limit: 2\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"organizations\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Organization id</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.name",
            "description": "<p>Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_limit",
            "description": "<p>Facility limit.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"organizations\",\n        \"id\": \"3\",\n        \"attributes\": {\n            \"name\": \"Apple Clinics\",\n            \"facility_limit: 2\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/organizations/3\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unique-organization",
            "description": "<p>Same name not allowed</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unique name",
          "content": "HTTP/1.1 400 Bad Request\n{\n   \"errors\": [\n       {\n           \"status\": \"400\",\n           \"source\": {\n               \"pointer\": \"data.attributes.name\"\n           },\n           \"detail\": \"Organization name must be unique.\"\n       }\n   ]\n}",
          "type": "json"
        },
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.name\"\n            },\n            \"detail\": \"The data.attributes.name field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Organization/OrganizationController.php",
    "groupTitle": "Organizations"
  },
  {
    "type": "get",
    "url": "/policies",
    "title": "Get policy list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Policies",
    "name": "Get_policy_list__filterable_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "facility_id",
            "description": "<p>Filter by facility id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "role_id",
            "description": "<p>Filter by role id.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"policies\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Policy id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>Role ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.entity",
            "description": "<p>Entity name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.view",
            "description": "<p>View access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.create",
            "description": "<p>Create access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.update",
            "description": "<p>Update access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.delete",
            "description": "<p>Delete access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"policies\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"facility_id\": 1,\n                \"role_id\": 6,\n                \"entity\": \"BillingLog\",\n                \"view\": 1,\n                \"create\": 0,\n                \"update\": 0,\n                \"delete\": 0,\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/policies/1\"\n            }\n        },\n        {\n            \"type\": \"policies\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"facility_id\": 1,\n                \"role_id\": 6,\n                \"entity\": \"BillingLog\",\n                \"view\": 0,\n                \"create\": 0,\n                \"update\": 0,\n                \"delete\": 0,\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/policies/2\"\n            }\n        },\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/PolicyController.php",
    "groupTitle": "Policies"
  },
  {
    "type": "put/patch",
    "url": "/policies/:id",
    "title": "Update policy",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Policies",
    "name": "Update_policy",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Policy id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"policies\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.view",
            "description": "<p>View access boolean.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.create",
            "description": "<p>Create access boolean.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.update",
            "description": "<p>Update access boolean.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.delete",
            "description": "<p>Delete access boolean.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"policies\",\n        \"attributes\": {\n            \"view\": 1,\n            \"create\": 1,\n            \"update\": 1,\n            \"delete\": 0,\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"policies\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Policy id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Facility ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>Role ID.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.entity",
            "description": "<p>Entity name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.view",
            "description": "<p>View access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.create",
            "description": "<p>Create access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.update",
            "description": "<p>Update access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.delete",
            "description": "<p>Delete access boolean.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"policies\",\n        \"id\": \"4\",\n        \"attributes\": {\n            \"facility_id\": 1,\n            \"role_id\": 6,\n            \"entity\": \"TransportLog\",\n            \"view\": 1,\n            \"create\": 0,\n            \"update\": 0,\n            \"delete\": 0,\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/policies/4\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/PolicyController.php",
    "groupTitle": "Policies"
  },
  {
    "type": "post",
    "url": "/transport-billing-logs",
    "title": "Add new transport billing log",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportBillingLog",
    "name": "Add_new_transport_billing_log_entry_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"transport-billing-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.destination_type",
            "description": "<p>Indicate type of location.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Transport type.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_start",
            "description": "<p>To Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_end",
            "description": "<p>To Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_start",
            "description": "<p>Return Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_end",
            "description": "<p>Return Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.fee",
            "description": "<p>Transport Fee.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport billing log date.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n  \"data\": {\n    \"type\": \"transport-billing-logs\",\n    \"attributes\": {\n      \"location_name\": \"Royce Spinka\",\n      \"client_name\": \"Ivory Kautzer\",\n      \"destination_type\": \"Aut id quo minima.\",\n      \"transport_type\": \"ambulatory\",\n      \"equipment\": \"ambulatory\",\n      \"mileage_to_start\": 1,\n      \"mileage_to_end\": 10,\n      \"mileage_return_start\": 11,\n      \"mileage_return_end\": 20,\n      \"fee\": 8,\n      \"date\": \"2018-05-06 17:38:01\",\n      \"user_id\": 7,\n      \"facility_id\": 4\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"transport-billing-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.destination_type",
            "description": "<p>Indicate type of location.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_start",
            "description": "<p>To Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_end",
            "description": "<p>To Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_start",
            "description": "<p>Return Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_end",
            "description": "<p>Return Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.fee",
            "description": "<p>Transport Fee.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport billing log date.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"type\": \"transport-billing-logs\",\n    \"id\": \"1\",\n    \"attributes\": {\n      \"location_name\": \"Erich Mertz\",\n      \"client_name\": \"Rory Stokes\",\n      \"destination_type\": \"Aliquam a impedit corrupti.\",\n      \"transport_type\": \"ambulatory\",\n      \"equipment\": \"ambulatory\",\n      \"mileage_to_start\": 1,\n      \"mileage_to_end\": 10,\n      \"mileage_return_start\": 11,\n      \"mileage_return_end\": 20,\n      \"fee\": 9,\n      \"date\": \"2018-05-06 17:30:52\",\n      \"user_id\": 7,\n      \"facility_id\": 4\n    },\n    \"links\": {\n      \"self\": \"http://api.journey.local/transport-billing-logs/1\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.location_name\"\n            },\n            \"detail\": \"The data.attributes.location_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.client_name\"\n            },\n            \"detail\": \"The data.attributes.client_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.destination_type\"\n            },\n            \"detail\": \"The data.attributes.destination_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.transport_type\"\n            },\n            \"detail\": \"The data.attributes.transport_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.equipment_type\"\n            },\n            \"detail\": \"The data.attributes.equipment_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_to_start\"\n            },\n            \"detail\": \"The data.attributes.mileage_to_start field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_to_end\"\n            },\n            \"detail\": \"The data.attributes.mileage_to_end field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_return_start\"\n            },\n            \"detail\": \"The data.attributes.mileage_return_start field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_return_end\"\n            },\n            \"detail\": \"The data.attributes.mileage_return_end field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.fee\"\n            },\n            \"detail\": \"The data.attributes.fee field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.date\"\n            },\n            \"detail\": \"The data.attributes.date field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.user_id\"\n            },\n            \"detail\": \"The data.attributes.user_id field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.facility_id\"\n            },\n            \"detail\": \"The data.attributes.facility_id field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportBillingLogController.php",
    "groupTitle": "TransportBillingLog"
  },
  {
    "type": "delete",
    "url": "/transport-billing-logs/:id",
    "title": "Delete transport billing log",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportBillingLog",
    "name": "Delete_transport_billing_log",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>TransportLog id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportBillingLogController.php",
    "groupTitle": "TransportBillingLog"
  },
  {
    "type": "get",
    "url": "/transport-billing-logs",
    "title": "Get transport billing log list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportBillingLog",
    "name": "Get_transport_billing_log_list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "facilityId",
            "description": "<p>Mandatory facility id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Mandatory page number, starts with 1.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "from",
            "description": "<p>Optional date parameter, format: &quot;Y-m-d H:i:s&quot;</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "to",
            "description": "<p>Optional date parameter, format: &quot;Y-m-d H:i:s&quot;</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"transport-billing-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>Transport log id.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.destination_type",
            "description": "<p>Indicate type of location.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_start",
            "description": "<p>To Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_end",
            "description": "<p>To Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_start",
            "description": "<p>Return Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_end",
            "description": "<p>Return Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.fee",
            "description": "<p>Transport Fee.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport billing log date.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "pagination",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.total",
            "description": "<p>Number of all result.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.count",
            "description": "<p>Number of result of the actual page.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.per_page",
            "description": "<p>Maximum number of result per page.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.current_page",
            "description": "<p>Current page number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.total_pages",
            "description": "<p>Number of available pages.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"type\": \"transport-billing-logs\",\n      \"id\": \"2\",\n      \"attributes\": {\n        \"location_name\": \"171 Vandervort Springs Apt. 476\",\n        \"client_name\": \"Michele Witting\",\n        \"destination_type\": \"Ipsum sint aut sint porro.\",\n        \"transport_type\": \"passenger\",\n        \"equipment\": \"ambulatory\",\n        \"mileage_to_start\": \"1\",\n        \"mileage_to_end\": \"10\",\n        \"mileage_return_start\": \"11\",\n        \"mileage_return_end\": \"20\",\n        \"fee\": \"5\",\n        \"date\": \"2011-04-19 18:04:22\",\n        \"user_id\": \"7\",\n        \"facility_id\": \"4\"\n      },\n      \"links\": {\n        \"self\": \"http://api.journey.local/transport-billing-logs/2\"\n      }\n    },\n   {\n      \"type\": \"transport-billing-logs\",\n      \"id\": \"1\",\n      \"attributes\": {\n        \"location_name\": \"49427 Bernier Loaf Apt. 148\",\n        \"client_name\": \"Jena Farrell\",\n        \"destination_type\": \"Neque ut a possimus aut.\",\n        \"transport_type\": \"wheelchair\",\n        \"equipment\": \"ambulatory\",\n        \"mileage_to_start\": \"1\",\n        \"mileage_to_end\": \"10\",\n        \"mileage_return_start\": \"11\",\n        \"mileage_return_end\": \"20\",\n        \"fee\": \"2\",\n        \"date\": \"1975-01-14 00:07:14\",\n        \"user_id\": \"7\",\n        \"facility_id\": \"4\"\n      },\n      \"links\": {\n        \"self\": \"http://api.journey.local/transport-billing-logs/1\"\n      }\n   }\n  ],\n  \"meta\": {\n    \"pagination\": {\n      \"total\": 2,\n      \"count\": 2,\n      \"per_page\": 15,\n      \"current_page\": 1,\n      \"total_pages\": 1\n    }\n  },\n  \"links\": {\n    \"self\": \"http://api.journey.local/api/transport-billing-logs?limit=15&from=&to=&page=1\",\n    \"first\": \"http://api.journey.local/api/transport-billing-logs?limit=15&from=&to=&page=1\",\n    \"last\": \"http://api.journey.local/api/transport-billing-logs?limit=15&from=&to=&page=1\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportBillingLogController.php",
    "groupTitle": "TransportBillingLog"
  },
  {
    "type": "put/patch",
    "url": "/transport-billing-logs/:id",
    "title": "Update transport billing log",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportBillingLog",
    "name": "Update_transport_billing_log",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"transport-billing-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.destination_type",
            "description": "<p>Indicate type of location.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Transport type.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_start",
            "description": "<p>To Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_end",
            "description": "<p>To Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_start",
            "description": "<p>Return Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_end",
            "description": "<p>Return Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.fee",
            "description": "<p>Transport Fee.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport billing log date.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n  \"data\": {\n    \"type\": \"transport-billing-logs\",\n    \"attributes\": {\n      \"location_name\": \"Royce Spinka\",\n      \"client_name\": \"Ivory Kautzer\",\n      \"destination_type\": \"Aut id quo minima.\",\n      \"transport_type\": \"ambulatory\",\n      \"equipment\": \"ambulatory\",\n      \"mileage_to_start\": 1,\n      \"mileage_to_end\": 10,\n      \"mileage_return_start\": 11,\n      \"mileage_return_end\": 20,\n      \"fee\": 8,\n      \"date\": \"2018-05-06 17:38:01\",\n      \"user_id\": 7,\n      \"facility_id\": 4\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"transport-billing-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.destination_type",
            "description": "<p>Indicate type of location.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.transport_type",
            "description": "<p>Transport type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_start",
            "description": "<p>To Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_to_end",
            "description": "<p>To Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_start",
            "description": "<p>Return Trip Destination Mileage: Start.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.mileage_return_end",
            "description": "<p>Return Trip Destination Mileage: End.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.fee",
            "description": "<p>Transport Fee.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport billing log date.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"type\": \"transport-billing-logs\",\n    \"id\": \"1\",\n    \"attributes\": {\n      \"location_name\": \"Erich Mertz\",\n      \"client_name\": \"Rory Stokes\",\n      \"destination_type\": \"Aliquam a impedit corrupti.\",\n      \"transport_type\": \"ambulatory\",\n      \"equipment\": \"ambulatory\",\n      \"mileage_to_start\": 1,\n      \"mileage_to_end\": 10,\n      \"mileage_return_start\": 11,\n      \"mileage_return_end\": 20,\n      \"fee\": 9,\n      \"date\": \"2018-05-06 17:30:52\",\n      \"user_id\": 7,\n      \"facility_id\": 4\n    },\n    \"links\": {\n      \"self\": \"http://api.journey.local/transport-billing-logs/1\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.location_name\"\n            },\n            \"detail\": \"The data.attributes.location_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.client_name\"\n            },\n            \"detail\": \"The data.attributes.client_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.destination_type\"\n            },\n            \"detail\": \"The data.attributes.destination_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.transport_type\"\n            },\n            \"detail\": \"The data.attributes.transport_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.equipment_type\"\n            },\n            \"detail\": \"The data.attributes.equipment_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_to_start\"\n            },\n            \"detail\": \"The data.attributes.mileage_to_start field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_to_end\"\n            },\n            \"detail\": \"The data.attributes.mileage_to_end field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_return_start\"\n            },\n            \"detail\": \"The data.attributes.mileage_return_start field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.mileage_return_end\"\n            },\n            \"detail\": \"The data.attributes.mileage_return_end field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.fee\"\n            },\n            \"detail\": \"The data.attributes.fee field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.date\"\n            },\n            \"detail\": \"The data.attributes.date field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.user_id\"\n            },\n            \"detail\": \"The data.attributes.user_id field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.facility_id\"\n            },\n            \"detail\": \"The data.attributes.facility_id field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportBillingLogController.php",
    "groupTitle": "TransportBillingLog"
  },
  {
    "type": "post",
    "url": "/transport-log",
    "title": "Add new transport log",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportLog",
    "name": "Add_new_transport_log_entry_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"transport-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.signature",
            "description": "<p>Signature.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "attributes.equipment_secured",
            "description": "<p>Equipment secured.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport log date time, format &quot;Y-m-d H:i:s&quot;</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.user_id",
            "description": "<p>Current user id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Current facility id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n   \"data\": {\n     \"type\": \"transport-logs\",\n     \"attributes\": {\n       \"location_name\": \"Everett Schaefer\",\n       \"client_name\": \"Olen Renner\",\n       \"equipment\": \"ambulatory\",\n       \"equipment_secured\": 1,\n       \"signature\": \"Leopold Collins\",\n       \"date\": \"2018-05-03 06:17:54\",\n       \"user_id\": 7,\n       \"facility_id\": 4\n     }\n   }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"transport-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>Transport log id.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.signature",
            "description": "<p>Signature.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "attributes.equipment_secured",
            "description": "<p>Equipment secured.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport log date time, format &quot;Y-m-d H:i:s&quot;</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.user_id",
            "description": "<p>Current user id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Current facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"type\": \"transport-logs\",\n    \"id\": \"1\",\n    \"attributes\": {\n      \"location_name\": \"Zack Mitchell\",\n      \"client_name\": \"Miss Rosalinda Shanahan\",\n      \"equipment\": \"ambulatory\",\n      \"equipment_secured\": 1,\n      \"signature\": \"Renee Durgan\",\n      \"date\": \"2018-05-03 06:21:15\",\n      \"user_id\": 7,\n      \"facility_id\": 4\n    },\n    \"links\": {\n      \"self\": \"http://api.journey.local/transport-logs/1\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.location_name\"\n            },\n            \"detail\": \"The data.attributes.location_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.client_name\"\n            },\n            \"detail\": \"The data.attributes.client_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.signature\"\n            },\n            \"detail\": \"The data.attributes.signature field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.equipment_type\"\n            },\n            \"detail\": \"The data.attributes.equipment_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.equipment_secured\"\n            },\n            \"detail\": \"The data.attributes.equipment_secured field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.date\"\n            },\n            \"detail\": \"The data.attributes.date field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.user_id\"\n            },\n            \"detail\": \"The data.attributes.user_id field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.facility_id\"\n            },\n            \"detail\": \"The data.attributes.facility_id field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportLogController.php",
    "groupTitle": "TransportLog"
  },
  {
    "type": "delete",
    "url": "/transport-logs/:id",
    "title": "Delete transport log",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportLog",
    "name": "Delete_transport_log",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>TransportLog id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportLogController.php",
    "groupTitle": "TransportLog"
  },
  {
    "type": "get",
    "url": "/transport-logs",
    "title": "Get transport log list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportLog",
    "name": "Get_transport_log_list",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "facilityId",
            "description": "<p>Mandatory facility id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Mandatory page number, starts with 1.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "from",
            "description": "<p>Optional date paramter, format: &quot;Y-m-d H:i:s&quot;</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "to",
            "description": "<p>Optional date paramter, format: &quot;Y-m-d H:i:s&quot;</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"transport-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>Transport log id.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.signature",
            "description": "<p>Signature.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "attributes.equipment_secured",
            "description": "<p>Equipment secured.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport log date time.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "pagination",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.total",
            "description": "<p>Number of all result.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.count",
            "description": "<p>Number of result of the actual page.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.per_page",
            "description": "<p>Maximum number of result per page.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.current_page",
            "description": "<p>Current page number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "pagination.total_pages",
            "description": "<p>Number of available pages.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"type\": \"transport-logs\",\n      \"id\": \"180\",\n      \"attributes\": {\n        \"location_name\": \"3151 Hahn Islands\",\n        \"client_name\": \"Prof. Lois Baumbach DVM\",\n        \"equipment\": \"wheelchair\",\n        \"equipment_secured\": 0,\n        \"signature\": \"Justyn Stamm MD\",\n        \"date\": \"2018-04-20 07:18:31\",\n        \"user_id\": 1,\n        \"facility_id\": 1\n      },\n      \"links\": {\n        \"self\": \"http://api.journey.local/transport-logs/180\"\n      }\n    }\n  ],\n  \"meta\": {\n    \"pagination\": {\n      \"total\": 1,\n      \"count\": 1,\n      \"per_page\": 15,\n      \"current_page\": 1,\n      \"total_pages\": 1\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportLogController.php",
    "groupTitle": "TransportLog"
  },
  {
    "type": "put/patch",
    "url": "/transport-logs/:id",
    "title": "Update transport log",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "TransportLog",
    "name": "Update_transport_log",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>Transport log id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"transport-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.signature",
            "description": "<p>Signature.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "attributes.equipment_secured",
            "description": "<p>Equipment secured.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport log date time, format &quot;Y-m-d H:i:s&quot;</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.user_id",
            "description": "<p>Current user id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Current facility id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n   \"data\": {\n     \"type\": \"transport-logs\",\n     \"attributes\": {\n       \"location_name\": \"Everett Schaefer\",\n       \"client_name\": \"Olen Renner\",\n       \"equipment\": \"ambulatory\",\n       \"equipment_secured\": 1,\n       \"signature\": \"Leopold Collins\",\n       \"date\": \"2018-05-03 06:17:54\",\n       \"user_id\": 7,\n       \"facility_id\": 4\n     }\n   }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"transport-logs\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<p>Transport log id.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.location_name",
            "description": "<p>Location name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.client_name",
            "description": "<p>Client name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.signature",
            "description": "<p>Signature.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.equipment_type",
            "description": "<p>Equipment type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "attributes.equipment_secured",
            "description": "<p>Equipment secured.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.date",
            "description": "<p>Transport log date time, format &quot;Y-m-d H:i:s&quot;</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.user_id",
            "description": "<p>Current user id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Integer",
            "optional": false,
            "field": "attributes.facility_id",
            "description": "<p>Current facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"type\": \"transport-logs\",\n    \"id\": \"1\",\n    \"attributes\": {\n      \"location_name\": \"Zack Mitchell\",\n      \"client_name\": \"Miss Rosalinda Shanahan\",\n      \"equipment\": \"ambulatory\",\n      \"equipment_secured\": 1,\n      \"signature\": \"Renee Durgan\",\n      \"date\": \"2018-05-03 06:21:15\",\n      \"user_id\": 7,\n      \"facility_id\": 4\n    },\n    \"links\": {\n      \"self\": \"http://api.journey.local/transport-logs/1\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.location_name\"\n            },\n            \"detail\": \"The data.attributes.location_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.client_name\"\n            },\n            \"detail\": \"The data.attributes.client_name field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.signature\"\n            },\n            \"detail\": \"The data.attributes.signature field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.equipment_type\"\n            },\n            \"detail\": \"The data.attributes.equipment_type field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.equipment_secured\"\n            },\n            \"detail\": \"The data.attributes.equipment_secured field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.date\"\n            },\n            \"detail\": \"The data.attributes.date field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.user_id\"\n            },\n            \"detail\": \"The data.attributes.user_id field is required.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.facility_id\"\n            },\n            \"detail\": \"The data.attributes.facility_id field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Logs/TransportLogController.php",
    "groupTitle": "TransportLog"
  },
  {
    "type": "post",
    "url": "/users",
    "title": "Add new user",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Users",
    "name": "Add_new_user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>User phone number.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number/null",
            "optional": true,
            "field": "attributes.color_id",
            "description": "<p>User color id (used for Master Users or ETC).</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"attributes\": {\n            \"first_name\": \"Greenfield\",\n            \"middle_name\": \"\",\n            \"last_name\": \"Jones\",\n            \"email\": \"jones.greenfield@journey.test\",\n            \"phone\": \"123-456\",\n            \"role_id\": 1,\n            \"color_id\": null,\n            \"organization\": {\n                \"id\": 1\n            },\n            \"facility\": {\n                \"id\": null\n            }\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String/null",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>User phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object/null",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>User color id (used for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"id\": \"4\",\n        \"attributes\": {\n            \"first_name\": \"Greenfield\",\n            \"middle_name\": null,\n            \"last_name\": \"Jones\",\n            \"email\": \"jones.greenfield@journey.test\",\n            \"phone\": \"123-789\",\n            \"role_id\": 1,\n            \"color_id\": null,\n            \"organization\": {\n                \"id\": 1,\n                \"name\": \"Silver Pine Ltd.\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            }\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/users/4\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unique-email",
            "description": "<p>Same email not allowed</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unique email",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.email\"\n            },\n            \"detail\": \"User email must be unique.\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes must contain 7 items.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.email\"\n            },\n            \"detail\": \"The data.attributes.email field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/UserController.php",
    "groupTitle": "Users"
  },
  {
    "type": "delete",
    "url": "/users/:id",
    "title": "Delete User",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Users",
    "name": "Delete_facility",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/UserController.php",
    "groupTitle": "Users"
  },
  {
    "type": "get",
    "url": "/users/:id",
    "title": "Get user by ID",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Users",
    "name": "Get_specified_user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>User color id (used for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n {\n    \"data\": {\n        \"type\": \"users\",\n        \"id\": \"1\",\n        \"attributes\": {\n            \"first_name\": \"Clark\",\n            \"middle_name\": \"\",\n            \"last_name\": \"Kent\",\n            \"email\": \"sa@journey.test\",\n            \"phone\": \"123-456\",\n            \"role_id\": 1,\n            \"color_id\": null,\n            \"organization\": {\n                \"id\": null,\n                \"name\": \"\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            }\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/users/1\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/UserController.php",
    "groupTitle": "Users"
  },
  {
    "type": "get",
    "url": "/users",
    "title": "Get user list",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "1.6.0",
    "group": "Users",
    "name": "Get_user_list__filterable_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "role_id",
            "description": "<p>Filter by role id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"first_name\"",
              "\"email\"",
              "\"role_id\""
            ],
            "optional": true,
            "field": "order_by",
            "description": "<p>Ordering column name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"ASC\"",
              "\"DESC\""
            ],
            "optional": true,
            "field": "order",
            "description": "<p>Ordering direction. (case-insensitive)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>If sent can paginate the list and receive a meta data</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>User phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>User color id (used for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta",
            "description": "<p>Only if sent a page GET parameter</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": true,
            "field": "meta.pagination",
            "description": "<p>Contains a data for pagination</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": [\n        {\n            \"type\": \"users\",\n            \"id\": \"1\",\n            \"attributes\": {\n                \"first_name\": \"Clark\",\n                \"middle_name\": \"\",\n                \"last_name\": \"Kent\",\n                \"email\": \"sa@journey.test\",\n                \"phone\": \"123-456\",\n                \"role_id\": 1,\n                \"color_id\": null,\n                \"organization\": {\n                    \"id\": null,\n                    \"name\": \"\"\n                },\n                \"facility\": {\n                    \"id\": null,\n                    \"name\": \"\"\n                }\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/users/1\"\n            }\n        },\n        {\n            \"type\": \"users\",\n            \"id\": \"2\",\n            \"attributes\": {\n                \"first_name\": \"Sylvester\",\n                \"middle_name\": \"Silver\",\n                \"last_name\": \"Pine\",\n                \"email\": \"oa@silverpine.test\",\n                \"phone\": \"123-456\",\n                \"role_id\": 2,\n                \"color_id\": null,\n                \"organization\": {\n                    \"id\": 1,\n                    \"name\": \"Silver Pine Ltd.\"\n                },\n                \"facility\": {\n                    \"id\": null,\n                    \"name\": \"\"\n                }\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/users/2\"\n            }\n        },\n        {\n            \"type\": \"users\",\n            \"id\": \"3\",\n            \"attributes\": {\n                \"first_name\": \"Sylvia\",\n                \"middle_name\": \"Silver\",\n                \"last_name\": \"Pine\",\n                \"email\": \"id@silverpine.test\",\n                \"phone\": \"123-456\",\n                \"role_id\": 5,\n                \"color_id\": 1,\n                \"organization\": {\n                    \"id\": 1,\n                    \"name\": \"Silver Pine Ltd.\"\n                },\n                \"facility\": {\n                    \"id\": 1,\n                    \"name\": \"Evergreen Retirement Home\"\n                }\n            },\n            \"links\": {\n                \"self\": \"http://api.journey.local/users/3\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/UserController.php",
    "groupTitle": "Users"
  },
  {
    "type": "put",
    "url": "/users/reset-password/:id",
    "title": "Reset user password",
    "permission": [
      {
        "name": "Organization Admin/Facility Admin"
      }
    ],
    "version": "0.0.1",
    "group": "Users",
    "name": "Reset_user_password",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/UserController.php",
    "groupTitle": "Users"
  },
  {
    "type": "put/patch",
    "url": "/users/:id",
    "title": "Update user",
    "permission": [
      {
        "name": "Authenticated"
      }
    ],
    "version": "0.0.1",
    "group": "Users",
    "name": "Update_user",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Request type.</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>User phone number.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number/null",
            "optional": true,
            "field": "attributes.color_id",
            "description": "<p>User color id (used for Master Users or ETC).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example usage:",
          "content": "body:\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"attributes\": {\n            \"first_name\": \"Yellowfield\",\n            \"middle_name\": \"\",\n            \"last_name\": \"Jones\",\n            \"phone\": \"123-456\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"users\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>Response type.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User id</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.first_name",
            "description": "<p>User first name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String/null",
            "optional": false,
            "field": "attributes.middle_name",
            "description": "<p>User middle name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.last_name",
            "description": "<p>User last name.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.email",
            "description": "<p>User email address.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.phone",
            "description": "<p>User phone number.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.role_id",
            "description": "<p>User role id.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "attributes.color_id",
            "description": "<p>User color id (used for calendar and we only use for Master Users or ETC).</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.organization",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.organization.id",
            "description": "<p>User Organization id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.organization.name",
            "description": "<p>User Organization name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "attributes.facility",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number/null",
            "optional": false,
            "field": "attributes.facility.id",
            "description": "<p>User Facility id.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "attributes.facility.name",
            "description": "<p>User Facility name.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "links",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "links.self",
            "description": "<p>Resource URL</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n    \"data\": {\n        \"type\": \"users\",\n        \"id\": \"4\",\n        \"attributes\": {\n            \"first_name\": \"Yellowfield\",\n            \"middle_name\": null,\n            \"last_name\": \"Jones\",\n            \"email\": \"jones.grenfield@journey.test\",\n            \"phone\": \"123-456\",\n            \"role_id\": 1,\n            \"color_id\": null,\n            \"organization\": {\n                \"id\": 1,\n                \"name\": \"Silver Pine Ltd.\"\n            },\n            \"facility\": {\n                \"id\": null,\n                \"name\": \"\"\n            }\n        },\n        \"links\": {\n            \"self\": \"http://api.journey.local/users/4\"\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Unique-email",
            "description": "<p>Same email not allowed</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Missing-attributes",
            "description": "<p>Required attributes missing</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Unique email",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.email\"\n            },\n            \"detail\": \"User email must be unique.\"\n        }\n    ]\n}",
          "type": "json"
        },
        {
          "title": "Missing attributes",
          "content": "HTTP/1.1 400 Bad Request\n{\n    \"errors\": [\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes\"\n            },\n            \"detail\": \"The data.attributes must contain 7 items.\"\n        },\n        {\n            \"status\": \"400\",\n            \"source\": {\n                \"pointer\": \"data.attributes.email\"\n            },\n            \"detail\": \"The data.attributes.email field is required.\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/User/UserController.php",
    "groupTitle": "Users"
  }
] });
