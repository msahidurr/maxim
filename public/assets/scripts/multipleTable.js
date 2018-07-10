
$(document).ready(function(){
  var parentLii = '';
    $('.idclone .tr_clone .item_code').on('keyup',function(){

      var parentLi = $('.idclone').find(this).parent().parent().parent().prop('className');

        $('.idclone .'+parentLi+' .item_code').on('keyup',function(){
          parentLii = $('.idclone').find(this).parent().parent().parent().prop('className');
        
        });
    });

    if(parentLii == ''){
      parentLii = 'tr_clone';
    }


    var incre = 0;
    $("#add").on('click',function(e) {
      e.preventDefault();

        var clone = '';
        if(parentLii == 'tr_clone'){
              clone = $('.idclone .'+parentLii+':last').clone(true).append('<div class="btn"><i class="fa fa-minus-circle" style="font-size:20px"></i></div>');                
          }else{
            clone = $('.idclone .'+parentLii+':last').clone(true);             
          }      

          clone.addClass('tr_clone_'+incre).removeClass(parentLii).appendTo(".idclone");
          incre++;
        // console.log(incre);
      return false;
    });

    $('.idclone').on('click', '.btn', function () {
     $(this).closest('tr').remove();
    });




  $('.idclone .'+parentLii+' .item_code').on('change',function(){

      var item_code = $.trim($(this).val());

      $.ajax({
          type: "GET",
          url: "/get/product/details/booking",
          data: "item="+item_code,
          datatype: 'json',
          cache: true,
          async: true,
          success: function(result) {
              var myObj = JSON.parse(result);
              console.log(myObj);
              if(myObj.length === 0)
              {
                $('.idclone .'+parentLii+' .erpNo').attr("disabled","true");
                $('.idclone .'+parentLii+' .itemSize').attr("disabled","true");
                $('.idclone .'+parentLii+' .itemGmtsColor').attr("readonly","true");

                $('.idclone .'+parentLii+' .erpNo').html($('<option>', {
                      value: "",
                      text : ""
                  }));
                $('.idclone .'+parentLii+' .itemSize').html($('<option>', {
                      value: "",
                      text : ""
                  }));

                $('.idclone .'+parentLii+' .itemGmtsColor').html($('<option>', {
                      value: "",
                      text : ""
                  }));

                  $('.idclone .'+parentLii+' .item_price').eq(incre).val('');                
                  $('.idclone .'+parentLii+' .item_price').eq(0).val('');                
                  $('.idclone .'+parentLii+' .item_qty').eq(0).val('');                

                
              }else{

                for(ik in myObj){
                  $('.idclone .'+parentLii+' .erpNo').html($('<option>', {
                      value: myObj[ik].erp_code,
                      text : myObj[ik].erp_code
                  }));
                }

                

                for(i in myObj){
                  if (myObj[i].size === null) {

                      $('.idclone .'+parentLii+' .itemSize').html($('<option>', {
                      value: "",
                      text : "empty Size"
                      }));

                  }else{

                    $('.idclone .'+parentLii+' .itemSize').html($('<option>', {
                    value: "",
                    text : "Select Size"
                    }));

                    var sizes = myObj[i].size.split(',');
                        sizes = $.unique(sizes);
                    for(j in sizes){
                      $('.idclone .'+parentLii+' .itemSize').append($('<option>', {
                        value: sizes[j],
                        text : sizes[j]
                    }));
                  }
                  }             
                }

                for(s in myObj){
                  if(myObj[s].color === null){
                    $('.idclone .'+parentLii+' .itemGmtsColor').html($('<option>', {
                    value: "",
                    text : "Empty Colors"
                    }));
                  }else{

                    $('.idclone .'+parentLii+' .itemGmtsColor').html($('<option>', {
                    value: "",
                    text : "Select colors"
                    }));

                    var colors = myObj[s].color.split(',');
                    var colors = $.unique(colors);
                    for(h in colors){
                      $('.idclone .'+parentLii+' .itemGmtsColor').append($('<option>', {
                        value: colors[h],
                        text : colors[h]
                    }));
                    }

                    $('.idclone .'+parentLii+' .itemGmtsColor').removeAttr("readonly","false");
                  }     
                }

                var increI = 0;
                for(ij in myObj){
                  $('.idclone .'+parentLii+' .others_color').eq(increI).val(myObj[ij].others_color);
                  $('.idclone .'+parentLii+' .item_description').eq(increI).val(myObj[ij].product_description);
                  $('.idclone .'+parentLii+' .item_price').eq(increI).val(myObj[ij].unit_price);
                  increI++;
                }

              $('.idclone .'+parentLii+' .erpNo').removeAttr("disabled","false");
              $('.idclone .'+parentLii+' .itemSize').removeAttr("disabled","false");

            }
          },
          error:function(result){
            alert("Error");
          }

      });
      // });
  });
});


// $(document).ready(function(){
//   console.log("aaa");
//   $('#item_code').autocomplete({
//     source : ["hello", "how", "do", "you", "do"],
//     select: function(event, ui){
//           $('#item_code').val('');
//     }
// });
// });