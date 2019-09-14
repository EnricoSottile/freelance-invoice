import { Validator } from 'jsonschema'

/**
 * wrapper module for object/json validation
 * 
 * @param {Object} object  
 * @param {Object} schema  (jsonschema)
 * 
 * https://github.com/tdegrunt/jsonschema
 * 
 */ 
export default function(object, schema) {                    
    const validation = new Validator().validate(object, schema);
    const isValid = validation.errors.length === 0;
    
    if (!isValid) {
        validation.errors.forEach(e => console.warn(e.stack,))
    }

    return isValid
}