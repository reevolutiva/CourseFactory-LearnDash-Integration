import { useEffect, useState } from "react";
import { createPortal } from "react-dom";
import "./styles/AppBack.scss";


// Importo comeponeentes.
import ListingProyect from "./ListingProyect";
import Header from "./components/Header";

function App() {
  const [projectViewList, setProjectViewList] = useState([]);
  const [skeleton, setSkeleton] = useState(true);
  const [post_id, setPost_id] = useState(false);
  const [userStatus, setUserStatus] = useState(0);
  const [ currentImport , setCurrentImport ] = useState({ id:"", title:"", status:"uninported" });

  // Esta seateado el apikey?.

  useEffect(() => {
    // Si es distino a false entonces hay proyectos.
    if (req_project_list != false) {
      setUserStatus(1);
      let limit = req_project_list.length - 1;

      while (projectViewList.length <= limit) {
        const element = req_project_list[limit];
        const exist = element.exist;
        const id = element.id;
        let post_id = exist ? element.post_id : "";

        //if(projectViewList.length < req_project_list.length){

        getProjectItem(id, (response) => {
          console.log("response");
          console.log(response);

          response.exist = exist;
          if (exist) {
            response.post_id = post_id;
          }
          setProjectViewList((prev) => {
            const old = [...prev];
            old.push(response);
            return old;
          });
        });

        limit--;
      }
    }

    // Si es false, no hay proyectos.
    if (req_project_list == false) {
    }
  }, []);

  useEffect(() => {
    if (userStatus >= 1) {
      if (projectViewList.length == req_project_list.length) {
        setSkeleton(false);
      }
    }
  }, [projectViewList]);

  function getProjectItem(id, callback) {
    wp.apiRequest({
      path: "/cfact/v1/cfact-get-project?project_import_id=" + id,
      method: "GET",
    })
      .then((response) => {
        callback(response);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  return (
    <div className="AppBack">
    
      

      <Header 
        projectViewList={projectViewList} 
        skeleton={skeleton} 
        userStatus={userStatus} 
        setUserStatus={setUserStatus}
        post_id={post_id}
        currentImport={currentImport}
        setCurrentImport={setCurrentImport}
        setPost_id={setPost_id}
      />     

      <ListingProyect
          projectViewList={projectViewList}
          req_project_list={req_project_list}
          skeleton={skeleton}
          post_id={post_id}
          setPost_id={setPost_id}
          setCurrentImport={setCurrentImport}

        />

      
    </div>
  );
}

export default App;
