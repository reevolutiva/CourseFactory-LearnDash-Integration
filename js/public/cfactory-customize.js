if(location.href.includes("topics")){
    const topic_comment_box = document.querySelector('#topic_comment_box');
    if(topic_comment_box){
        topic_comment_box.append(document.querySelector('.wp-block-comments'));
    }
    
}    