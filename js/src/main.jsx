import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import AppBack from './AppBack';
import LoginForm from "./components/LoginForm";
import LoginPopUp from "./components/LoginPopUp";

if(document.getElementById('my-front')){
	ReactDOM.createRoot(document.getElementById('my-front')).render(
		<App />
);
}

if(document.getElementById('cfact_list')){
	ReactDOM.createRoot(document.getElementById('cfact_list')).render(
		<AppBack />
	);
}

if(document.getElementById('cfact_login')){
	ReactDOM.createRoot(document.getElementById('cfact_login')).render(
		<LoginForm />
	);
}

if(document.getElementById('cfact_login_popup')){
	ReactDOM.createRoot(document.getElementById('cfact_login_popup')).render(
		<LoginPopUp />
	);
}

