

/**
 * retrieve an object's nested prop using dot notation
 * 
 * let obj = {a: {b: {c: 'd'}}};
 * let val = func(obj, 'a.b.c') // results => 'd'
 * 
 * @param {Object} obj 
 * @param {String} descendant (prop1 || prop1.prop2 || ..... )
 * 
 * https://stackoverflow.com/questions/8051975/access-object-child-properties-using-a-dot-notation-string
 * 
 */ 
export default function (obj, descendant) {
    let arr = descendant.split('.');
    while (arr.length && (obj = obj[arr.shift()]));
    return obj;
}