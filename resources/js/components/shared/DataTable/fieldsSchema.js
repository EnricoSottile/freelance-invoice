
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
        "percent": {"type": "boolean", "required":false},
        "money": {
            "type": "object", 
            "required":false,
            "properties": {
                "locale": {"type": "string", "required": false},
                "moneyOptions": {
                    "type": "object", 
                    "required": false,
                },
            }
        },
        "link": {
            "type": "object", 
            "required": false,
            "properties": {
                "view": {"type": "string", "required":true},
                "params": {
                    
                    // "type": "object", // and function  
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