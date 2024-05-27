if(location.href.includes("topics")){
    const topic_comment_box = document.querySelector('#topic_comment_box');
    if(topic_comment_box){
        topic_comment_box.append(document.querySelector('.wp-block-comments'));
    }
    
}    

if( document.querySelectorAll(".ld-item-list-items .ld-item-name .ld-item-components > span") ){

    const cfact_ld_topic_itemo_for_delete = document.querySelectorAll(".ld-item-list-items .ld-item-name .ld-item-components > span");

for (let index = 0; index < cfact_ld_topic_itemo_for_delete.length; index++) {

    const element = cfact_ld_topic_itemo_for_delete[index];

    if( element.textContent.includes("Topics") ){
        element.style.display = "none";
        cfact_ld_topic_itemo_for_delete[index - 1].style.display = "none";
    }
    
}


}
