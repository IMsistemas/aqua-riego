/**
 * Created by Raidel Berrillo Gonzalez on 16/10/2016.
 */



/**
 * Funcion que endependencia del 2do parametro, convierte el formato de fecha
 *
 * @param strin_date
 * @param revert
 * @return string
 */
function convertFormatDate(strin_date, revert){
    if (revert == undefined){
        var t = strin_date.split('/');
        return t[2] + '-' + t[1] + '-' + t[0];
    } else {
        var t = strin_date.split('-');
        return t[2] + '/' + t[1] + '/' + t[0];
    }
}