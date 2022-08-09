//Validate Form
export function validate(nameValues, nameUrl)
{
    const expression = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/;
    const regExp = new RegExp(expression);

    if (!nameValues || !nameUrl) {
        alert('Please submit values for both fields')
        return false;
    }
    if (!nameUrl.match(regExp)) {
        alert('Please provide a valid web adress');
        return false;
    }
    return true;
}


 //Chech the Schema
 export const chechUrlScheme = (url) => {

    const Schema = (!url.includes('http://') && !url.includes('https://'));

    return Schema ? `https//:${url}` : url;

}