function cfact_project (projectId){    

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Token 9a9ae4de085f3d7039b7569d1222921258e359c8");
    
    var requestOptions = {
      method: 'GET',
      headers: myHeaders,
      redirect: 'follow',
      mode: 'cors'
    };
    
    fetch("https://cob.coursefactory.net/outline-builder/api/public/project/52355/version/60054", requestOptions)
      .then(response => response.text())
      .then(result => console.log(result))
      .catch(error => console.log('error', error));
      
}

export {cfact_project};