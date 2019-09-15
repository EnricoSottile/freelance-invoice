import _getDescendantProp from '@helpers/getDescendantProp'

/**
 * Get a property from a nested object and pull it up
 * 
 * @param {Array} collection 
 * @param {String} key 
 * @param {String} selector (prop1 || prop1.prop2 || ..... )
 * 
 * 
 * collection = [{a: 'b', c: {d: 'e'}}]  
 * {key: 'foo', selector: 'c.d'}
 * result => [ {a: 'b', c: {d: 'e'}, foo: 'e' } ]
 */ 
export default function(collection, {key, selector}) {
    return collection.map(item => {
        const value = _getDescendantProp(item, selector);

        if (!value) console.warn(`Value not found: [${selector}]`);

        item[key] = value;
        return item;
    });
}