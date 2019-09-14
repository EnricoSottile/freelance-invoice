
/**
 * date format with defaults
 * 
 * @param {Object} options 
 * @param {String} dateString
 */ 
export default function(dateOptions = {}, dateString) {
    const locale = dateOptions.locale || 'en-US';
    return new Date(dateString).toLocaleDateString(locale, dateOptions);
}