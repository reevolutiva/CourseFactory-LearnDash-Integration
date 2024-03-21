const RequestCourse = (slug ,title, content, template, status, author) =>{

    const tempalte = {
        "slug": slug,
        "status": status,
        "password": "",
        "title": title,
        "content": content,
        "author": author,
        "featured_media": 2,
        "comment_status": "abierto",
        "ping_status": "abierto", 
        "menu_order": 0,
        "template": "",
        "categories": [1,2,3],
        "tags": [1,2,3],
        "ld_course_category": [1,2,3],
        "ld_course_tag": [1,2,3],
        "materials_enabled": true,
        "materials": ["material1", "material2"],
        "certificate": 0,
        "disable_content_table": false,
        "lessons_per_page": false,
        "lesson_per_page_custom": 10,
        "topic_per_page_custom": 5,
        "price_type": "closed",
        "price_type_paynow_price": "10",
        "price_type_subscribe_price": "5", 
        "price_type_closed_price": "15",
        "price_type_closed_custom_button_url": "",
        "prerequisite_enabled": true,
        "prerequisite_compare": "ALL",
        "prerequisites": [1,2,3],
        "points_enabled": true,
        "points_access": 0.7,
        "points_amount": 0.7,
        "expire_access": true,
        "expire_access_days": 30,
        "expire_access_delete_progress": false,
        "progression_disabled": false
      };

       return tempalte;
}

export {RequestCourse};