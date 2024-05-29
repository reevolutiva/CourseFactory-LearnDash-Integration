import React from 'react';


const CF_Proyect_Skeleton = ({ proyecto }) => {

    return (
      <div className="cfact-proyecto-item col-4">
        <div className="cfact-proyecto-item__inside">
  
          <div className="cfact-proyecto-item__loader">
  
              <span></span>
              <h4>{bakendi18n.loading}</h4>
  
          </div>
        
          <div className="cfact-proyecto-item__footer">
              <p>Version: {proyecto.id}</p>
          </div>
        </div>
      </div>
    );
  };

  export default CF_Proyect_Skeleton;