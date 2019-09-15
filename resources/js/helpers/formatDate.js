import userPreferences from '../userPreferences'

/**
 * date format with defaults
 * 
 * @param {Object} options 
 * @param {String} dateString
 */ 
export default function(dateOptions = {}, dateString) {
    const locale = dateOptions.locale || userPreferences.locale;
    return new Date(dateString).toLocaleDateString(locale, dateOptions);
}