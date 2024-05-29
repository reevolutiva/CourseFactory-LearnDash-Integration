const useRequest = ({path, method, body, callback}) => {

    const myHeaders = new Headers();
    myHeaders.append("X-WP-Nonce", wpApiSettings.nonce);
    myHeaders.append("Cookie", loggedCookie);
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
    method: method,
    headers: myHeaders,
    body: body,
    redirect: 'follow'
    };

fetch(location.origin+"/wp-json/"+path, requestOptions)
  .then(response => response.text())
  .then(result => callback(result))
  .catch(error => console.log('error', error));
}
 
export default useRequest;