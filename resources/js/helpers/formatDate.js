
/**
 * date format with defaults
 * 
 * @param {Object} options 
 * @param {String} dateString
 */ 
export default function(options, dateString) {
    const locale = options.locale || 'en-US';
    const dateOptions = options.dateOptions || {
                     weekday: 'short', 
                     year: 'numeric', 
                     month: 'long', 
                     day: 'numeric'
                };
    return new Date(dateString).toLocaleDateString(locale, dateOptions);
}