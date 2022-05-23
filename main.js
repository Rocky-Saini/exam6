$("#form").validate({
    rule:{
        ProdName:{
           ProdName:true
        },
        messages:{
         required:'please enter product name'
        }
    }
    
   });