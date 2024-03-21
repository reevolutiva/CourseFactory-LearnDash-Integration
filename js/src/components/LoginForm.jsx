import { useEffect, useState } from "react";
import logo from "../../public/Logo_BG_black.png";
import gear from "../../public/gear.png";
import help from "../../public/help.png";

import "../styles/LoginForm.scss";

const LoginForm = () => {

    const [api_key, setApi_key] = useState(cfact_learndash_integration_apiKey);


    function hanndleInput(e){

        const contenido = e.target.value;
        setApi_key(contenido);
        
    }

    function settingHanlder() {
        
        location.href = `${location.origin}/wp-admin/admin.php?page=course_factory_integration`;
    
    }
    
    function helpHandler(){
        const mail = cfact_current_user.data.user_email;
        const date = new Date().toISOString();
        const from_url = cfact_blog_info.url; 

        const url = `https://coursefactory.reevolutiva.cl/ayuda/?email=${mail}&date=${date}&from_url=${from_url}`;
        window.open(url);
    }
    

    return ( 
        <div className="LoginForm-contain">
            <div className="header mb-5">

            <h1>
                <img src={logo} />
                <span>{bakendi18n.learndash_integration}</span>
            </h1>

            <div className="button_contain" >
                <button className="help" onClick={e => helpHandler() }>
                    <img src={help} />
                </button>

                <button className="setting" onClick={e => settingHanlder()}>
                    <img src={gear} />
                </button>
            </div>    
        </div>    
        <div className="LoginForm">       
            <section>
                <h3>{bakendi18n.insert_your_api_key}</h3>
                <a target="_blank" href="https://cob.coursefactory.net/login">
                    <p>{bakendi18n.where_to_fin_api}</p>
                </a>
            </section> 
            <form method="GET" action={`${location.origin}/wp-admin/admin.php?`}>
                    <input type="hidden" name="page" value="course_factory_integration"  />
                    <input type="hidden" name="cfact_view_config" value=""  />
                    <input type="hidden" name="set-api_key"  />
                    <label>
                          {
                                cfact_learndash_integration_apiKey !== "" ? 
                                <input disabled="true" type="text" value={api_key}  onChange={e => hanndleInput(e)} name="api-key" placeholder="*********" /> : 
                                <input type="text" value={api_key}  onChange={e => hanndleInput(e)} name="api-key" placeholder="*********" />
                          }
                          
                          {cfact_learndash_integration_apiKey !== "" ? <p><a href={`${location.origin}/wp-admin/admin.php?page=course_factory_integration&delete-api_key`}>{bakendi18n.delete_api_key}</a></p> : <p></p> }
                    </label>
                    <button type="submit" className="btn-cfac mt-3">{bakendi18n.conect_to_course_factory}</button>
            </form>

            <section className="mt-3 LoginForm--footer">
                <p>{bakendi18n.you_dont_have}  <a target="_blank" href="https://cob.coursefactory.net/signup?promo=LDPlugin"> <b>{bakendi18n.open_you_free}</b> </a> </p>
            </section>

            <section className="mt-3 keep-me">
                <p>{bakendi18n.keepme_informed}  <input type="checkbox" name="keepme-informed"  checked="true" /> </p>
            </section>
            

            
        </div>
        </div>
     );
}
 
export default LoginForm;