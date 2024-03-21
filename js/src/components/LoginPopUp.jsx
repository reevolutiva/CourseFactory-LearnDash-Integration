import "../styles/LoginPopUp.scss";
import logo from "../../public/Logo_BG_black.png";

const LoginPopUp = () => {

    function hiddenModal(){
        document.querySelector(".LoginPopUp-contain").style.display = "none";
    }

    return ( 
    <div className="LoginPopUp-contain" >
        <div className="overlay">
            <div className="LoginPopUp">

                <picture className="pb-4" >   <img src={logo} /> </picture>

                <h5> { bakendi18n.welcome_to } <b>{ bakendi18n.course_factory_integration_for_learndash }</b> </h5>
                <p>{ bakendi18n.unlock_the_power }</p>

                <div className="info d-flex justify-content-between py-4">
                    <button className="btn btn-cfact" > <a target="_blank" href="https://cob.coursefactory.net/signup?promo=LDPlugin"> <b>{bakendi18n.create_a_new_copilot}</b> </a>  </button>
                    <button onClick={ () => hiddenModal()} className="btn btn-cfact-ghost" > {bakendi18n.our_user_your_exist} </button>
                </div>

                <p> *No credit cards needed </p>

            </div>
        </div>
    </div> 
    );
}
 
export default LoginPopUp;