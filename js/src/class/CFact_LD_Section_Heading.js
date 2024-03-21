class CFact_LD_Section_Heading{

    constructor(order, post_title){
       this.order = order;
       this.post_title = post_title;
       this.ID = parseInt(Math.random() * 100000);
       this.expanded = false;
       this.tree = [];
       this.type = "section-heading";
       this.url = "";
    }
    
 }

 export default CFact_LD_Section_Heading