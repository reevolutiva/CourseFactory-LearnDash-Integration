import { useState, useEffect } from "react";
import LoadBar from "./LoadBar";

const CourseImportLoader = ({ post_id, json, currentImport, setPost_id}) => {

    const curso_name = "Curso 1";
    const [load, setLoad] = useState(false);
    // const [ progres, setProgress ] = useState([ false, false, false, false ]);
    // const [ current, setCurrent ] = useState([]);

    useEffect( () => {
        
        if(post_id){
        
          wp.apiRequest({
            method:"GET",
            path:"/wp/v2/sfwd-courses?post_id="+post_id
          }).then(
            e => console.log(e)
          ).catch(
            e => console.error(e)
          )

          setLoad(true);
        }

    }, [post_id]);

    return ( 
    
        <div className="py-3 bg-white p-3" id="course-import-loader-bar" style={{display:"none"}} >
            <h5>
                {
                    load ? `El curso: "${currentImport.title}" fue importado correctamente`
                    : 
                    `Importando Curso: "${currentImport.title} "`
                }
            </h5>
                
            <div className="py-4">
                {
                    !load ? 
                    <>  
                       <div
                            className="spinner-grow cfact-color bg-info"
                            role="status"
                        >
                            <span className="sr-only"></span>
                        </div>
                        <div className="spinner-grow cfact-color " role="status">
                            <span className="sr-only"></span>
                        </div>
                        <div
                            className="spinner-grow cfact-color bg-info"
                            role="status"
                        >
                        <span className="sr-only"></span>
                        </div>
                    </> 
                    : 
                    <div>
                        <button onClick={e =>  { 
                                e.preventDefault();
                                document.querySelector('#course-import-loader-bar').style.display = "none";
                                setPost_id(false);
                                setLoad(false);

                        } } 
                        className="btn btn-cfact" > Continuar </button>
                    </div>
                }
                
              </div>
            </div>
    );
}
 
export default CourseImportLoader;