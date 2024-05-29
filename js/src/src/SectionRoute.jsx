import { useEffect } from "react";
import ListingProyect from "./ListingProyect";
import LoginForm from "./components/LoginForm";

const SectionRoute = () => {
    

    const [cursor, setCursor] = useState(<LoginForm />);

    useEffect( () => {

        if(req_project_list){
            setCursor( 
                <ListingProyect 
                projectViewList={projectViewList}
                skeleton={skeleton}
            />
            )
        }

    }, []);

    return ( 
        <div>
            {cursor}
        </div>
     );
}
 
export default SectionRoute;