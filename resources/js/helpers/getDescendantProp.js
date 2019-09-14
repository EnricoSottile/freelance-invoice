

/**
 * money format with defaults
 * 
 * @param {Object} obj 
 * @param {String} desc (prop1 || prop1.prop2 || ..... )
 * 
 * https://stackoverflow.com/questions/8051975/access-object-child-properties-using-a-dot-notation-string
 * 
 */ 
export default function getDescendantProp (obj, desc) {
    let arr = desc.split('.');
    while (arr.length && (obj = obj[arr.shift()]));
    return obj;
}