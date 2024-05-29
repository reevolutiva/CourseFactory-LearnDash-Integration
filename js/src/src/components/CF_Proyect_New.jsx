import "../styles/CF_Proyect_New.scss";
const CF_Proyect_New = () => {
    return ( 
        <div className="cfact-proyecto-item cfact-proyecto-item-new col-4">
            <a target="_blank" href="https://cob.coursefactory.net/course/new/en/manual/settings">

            <div className="cfact-proyecto-item__inside" >

            <picture>
                <h4>{bakendi18n.new_project}</h4>
                {/*<!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--> */}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
            </picture>
            
            </div>
            </a>
        </div>

     );
}
 
export default CF_Proyect_New;