import Feather from 'feather-icons'

/**
 * return an svg icon from FeatherIcons
 * 
 * @param {String} icon 
 */ 
export default function(icon) {
    return Feather.icons[icon].toSvg();
}