
/**
 * money format with defaults
 * 
 * @param {Number} digits 
 * @param {Object} options
 */ 
export default function(digits, options) {
    const locale = options.locale || 'en-GB';
    const params = options.moneyOptions || { style: 'currency', currency: 'EUR' };
    return new Intl.NumberFormat(locale, params).format(digits)
}



