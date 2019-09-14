
/**
 * Validation schema for {fields} property in datatables
 * (jsonschema)
 * 
 * https://github.com/tdegrunt/jsonschema
 * 
 */ 
export default {
    "type": "object",
    "properties": {
        "name": {"type": "string", "required": true},
        "label": {"type": "string", "required": true},
        "link": {
            "type": "object", 
            "required": false,
            "properties": {
                "view": {"type": "string", "required":true},
                "params": {
                    "type": "object", 
                    "required": true,
                    "properties": {
                        "name": {"required": true},
                        "property": {"required": true},
                    }
                },
            }
        },
        "date": {
            "type": "object", 
            "required": false,
            "properties": {
                "dateOptions": {
                    "type": "object", 
                    "required": false,
                },
            }
        },
    }
}