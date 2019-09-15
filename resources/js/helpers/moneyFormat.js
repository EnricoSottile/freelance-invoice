import userPreferences from '../userPreferences'

/**
 * money format with defaults
 * 
 * @param {Number} digits 
 * @param {Object} options
 */ 
export default function(digits, options) {
    const locale = options.locale || userPreferences.locale;
    const params = options.moneyOptions || { style: 'currency', currency: userPreferences.currency };
    return new Intl.NumberFormat(locale, params).format(digits)
}



