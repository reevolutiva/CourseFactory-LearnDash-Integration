import React from "react";
import { useEffect, useState } from "react";

const LoadBar = ({ progresData, req_project_list }) => {
  useEffect(() => {
    const size = progresData.length;
    const totalSize = req_project_list.length;
    const percentage = (size / totalSize) * 100;

    setProgress(percentage);
  }, [progresData]);

  const [progress, setProgress] = useState(0);

  return (
    <div className="progress">
      <div
        className="progress-bar progress-bar-striped bg-info"
        role="progressbar"
        style={{ width: `${progress}%` }}
        aria-valuenow="50"
        aria-valuemin="0"
        aria-valuemax="100"
      ></div>
    </div>
  );
};

export default LoadBar;
