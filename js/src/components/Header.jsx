import logo from "../../public/Logo_BG_black.png";
import gear from "../../public/gear.png";
import help from "../../public/help.png";
import CourseImportLoader from "./CourseImportLoader";
import LoadBar from "./LoadBar";

const Header = ({projectViewList, skeleton, userStatus, setUserStatus, post_id, currentImport, setPost_id }) => {

  function settingHanlder() {
        
    location.href = `${location.href}&cfact_view_config`;

  }

  function helpHandler(){
    const mail = cfact_current_user.data.user_email;
    const date = new Date().toISOString();
    const from_url = cfact_blog_info.url; 

    const url = `https://coursefactory.reevolutiva.cl/ayuda/?email=${mail}&date=${date}&from_url=${from_url}`;
    window.open(url);
}
  
  return (
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

      {skeleton && userStatus > 0 && (
        <>
          <LoadBar
            progresData={projectViewList}
            req_project_list={req_project_list}
          />

          <h5>{bakendi18n.load_courses}</h5>
        </>
      )}

    <CourseImportLoader post_id={post_id} setPost_id={setPost_id} currentImport={currentImport} />

     
    </div>
  );
};

export default Header;
