const RequestTopic = (slug ,title, content, templ, status, author, course, lesson) =>{
    const template = {
         "slug": slug,
         "status": status,
         "password": "",
         "title": title,
         "content": content,
         "author": author,
         "featured_media": 456,
         "comment_status": "open",
         "ping_status": "open",
         "menu_order": 1,
         "meta": {
           "duration": "2 hours" 
         },
         "template": "",
         "categories": [],
         "tags": [],
         "ld_topic_category": [],
         "ld_topic_tag": [],
         "materials_enabled": true,
         "materials": [],
         "video_enabled": true, 
         "video_url": "" ,
         "video_shown": "AFTER",
         "video_auto_complete": true,
         "video_auto_complete_delay": 10,
         "video_show_complete_button": true,
         "video_auto_start": false,
         "video_show_controls": true,
         "video_focus_pause": true,
         "video_resume": true,
         "assignment_upload_enabled": true,
         "assignment_upload_limit_extensions": "pdf,doc",
         "assignment_upload_limit_size": 10000000,
         "assignment_points_enabled": true,
         "assignment_points_amount": 15,
         "assignment_auto_approve": false,
         "assignment_upload_limit_count": 1,
         "assignment_deletion_enabled": true,
         "forced_timer_enabled": true,
         "forced_timer_amount": 3600,
         "course": course,
         "lesson": lesson
       };

       return template;
}

export {RequestTopic};