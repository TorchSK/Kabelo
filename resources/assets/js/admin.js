$('.admin_categories_list .accordion').nestedSortable({
  handle: '.handle',
  items: '.category',
  listType: 'ul',
  disableParentChange: false,
  stop: function(event, ui){
    $data = [];
    $orders = {};
    $parents = {};

    $('.admin_categories_list .accordion .category').each(function(index, item){
      $orders[$(item).data('id')] = index;
      $parents[$(item).data('id')] = $(item).closest('li').parent().closest('li').data('id');
    });
    //console.log($(ui.item).closest('li').parent().closest('li').data('categoryid'));

    $.ajax({
      method: "PUT",
      url: '/categories/setorder',
      data: {'orders':$orders, 'parents': $parents}
    })
  }
});

$('.pages_list').nestedSortable({
  handle: '.handle',
  items: '.item',
  listType: 'ul',
  disableParentChange: false,
  stop: function(event, ui){
    $data = [];
    $orders = {};
    $parents = {};

    $('.pages_list .item').each(function(index, item){
      $orders[$(item).data('id')] = index;
      $parents[$(item).data('id')] = $(item).closest('li').parent().closest('li').data('id');
    });
    //console.log($(ui.item).closest('li').parent().closest('li').data('categoryid'));

    $.ajax({
      method: "PUT",
      url: '/pages/setorder',
      data: {'orders':$orders, 'parents': $parents}
    })
  }
});

$('.change_cat_img_btn').click(function(){
  $('#category_image_dropzone').click();
});

$('#xml_dropzone').dropzone({
  clickable: '#xml_upload_btn',
  success: function(file, response){
        $('#xml_url_input').val(response);
        $('#xml_url_input').data('external',0);
    }
});


$('#catalogue_dropzone').dropzone({
  clickable: '.catalogue_upload_btn',
  success: function(file, response){
        location.reload();
    }
});

$('#sticker_dropzone').dropzone({
  clickable: '.sticker_upload_btn',
  success: function(file, response){
        location.reload();
    }
});

$('#catalogue_image_dropzone_1').dropzone({
  clickable: '#catalogue_image_btn_1',
  success: function(file, response){
        location.reload();
    }
});


$('#catalogue_image_dropzone_2').dropzone({
  clickable: '#catalogue_image_btn_2',
  success: function(file, response){
        location.reload();
    }
});



$('#catalogue_image_dropzone_3').dropzone({
  clickable: '#catalogue_image_btn_3',
  success: function(file, response){
        location.reload();
    }
});


$('#product_detail_dropzone').dropzone({
  params: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    }
});


$('#file_dropzone').dropzone({
    params: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response){
        location.reload();
    }
});

$('#import_dropzone').dropzone({
    success: function(param, data){
      $table = $('#admin_import_results').find('table');
      $row = $table.find('tbody tr');
      $.each(data, function(index,item){
        $lastRow = $table.find('tbody tr:last-child');
        $lastRow.find('td[col="name"]').html(item['name']);
        $lastRow.find('td[col="code"]').html(item['code']);
        $lastRow.find('td[col="maker"]').html(item['maker']);

        console.log(item);

        $row.clone().appendTo($table);

      })

      //delete the duplicate last row
      $table.find('tbody tr:last-child').remove();
    },
    params: {
      '_token': $('meta[name="csrf-token"]').attr('content')
    }
})

$('#category_image_dropzone').dropzone({
  success: function(file, response){
    
    this.removeAllFiles(true);
    $categoryid = $('#category_image_div').data('categoryid');

    $.ajax({
      method: "POST",
      url: '/category/'+$categoryid+'/image/confirmCrop',
      data: {filename: file.name},
      success: function(){
        location.reload();
      }
    })

  } 
});

$('#cover_dropzone').dropzone({
  clickable: ['#admin_add_cover_change_image_btn', '#cover_dropzone'],
  success: function(file, response){
    var $x, $y, $w, $h;
    this.removeAllFiles(true); 
    $('.crop_preview').html("<img src=/"+response+" />").unbind('focus');
    $('.admin_add_cover_under').css('display','flex');
    $('.cover_image').show();
    $('#cover_dropzone').hide();
    $('#admin_add_cover_form input[name="filename"]').val(file.name);
    $('#admin_add_cover_change_image_btn').hide();

    if($('input[name="type"]').val()=='cover')
    {
      $aspect = $('#cover_ratio').text();
    }
    else
    {
      $aspect = $('#banner_ratio').text();;
    }

    $('.crop_preview img').cropper({
      guides: false,
      viewMode: 1,
      aspectRatio: $aspect,
      autoCropArea: 1,

      crop: function(e){
        $('#admin_add_cover_form input[name="x"]').val(e.x);
        $('#admin_add_cover_form input[name="y"]').val(e.y);
        $('#admin_add_cover_form input[name="w"]').val(e.width);
        $('#admin_add_cover_form input[name="h"]').val(e.height);

      },
      preview: $('.cover_image .cover')
    });


    // confirm crop
    $('.crop_ok').show().click(function(){
      $categoryid = $(this).data('categoryid');

      $.ajax({
        method: "POST",
        url: '/category/'+$categoryid+'/image/confirmCrop',
        data: {filename: file.name, x: $x, y:$y, w:$w, h:$h},
        success: function(){
          location.reload();
        }
      })
    });

  }
});

$('.ui.accordion').accordion({
  exclusive: false
}); 


$('#filterbar .ui.accordion').accordion({
  exclusive: false,
    selector    : {
    accordion : '.accordion',
    title     : '.title',
    trigger   : '.title i',
    content   : '.content'
  }
}); 

$('.admin_categories_list .ui.accordion').accordion({
  exclusive: false,
    selector    : {
    accordion : '.accordion',
    title     : '.title',
    trigger   : '.name',
    content   : '.content'
  }
}); 


$('#admin #grid .product.item').draggable({ 
  opacity: 0.6, 
  helper: "clone"
});

$('.categories .item').droppable({
  tolerance: "pointer",
  accept: ".product",
  over: function( event, ui ) {
    $(this).addClass('active');
  },
  out: function( event, ui ) {
    $(this).removeClass('active');
  },
  deactivate: function( event, ui ) {
    $(this).removeClass('active');
  },
  drop: function( event, ui ) {
    $categoryId = $(this).data('categoryid');
    $product = $(ui.draggable);

    $.post('/product/'+$product.data('productid')+'/change/category/'+$categoryId,{},function(){
          $product.remove();
    });

    $(this).removeClass('active');
  }

});

$('.sticker_preview_div .sticker').draggable({ 
  containment: "parent",
  create: function(){
    stikcer_left = 0;
    sticker_right = 0;
  },
  stop: function(){

    sticker_left = $(this).position().left;
        sticker_top = $(this).position().top;

  }

});

$('.sticker_preview_div .sticker').resizable({ 
  containment: "parent",
  create: function(){
    sticker_width = $(this).width();
    sticker_height = $(this).height();
  },
  stop: function(){   
    sticker_width = $(this).width();
        sticker_height = $(this).height();
  }

});

$('.admin_cover_list').sortable({
  stop: function(){
    $data = {};

    $('.admin_cover_list .banner').each(function(index, item){
      $data[$(item).data('id')] = index;
    });

    $.ajax({
      method: "PUT",
      url: '/admin/covers/setorder',
      data: $data
    })
  }
});

$('.admin_banner_list').sortable({
  stop: function(){
    $data = {};

    $('.admin_banner_list .banner').each(function(index, item){
      $data[$(item).data('id')] = index;
    });

    $.ajax({
      method: "PUT",
      url: '/admin/banners/setorder',
      data: $data
    })
  }
});



$('#admin_new_wrapper table tbody').sortable({
  helper: fixHelper,
  stop: function(){
    $data = {};

    $('#admin_new_wrapper table tbody tr').each(function(index, item){
      $data[$(item).data('id')] = index;
    });

    $.ajax({
      method: "PUT",
      url: '/products/new/setorder',
      data: $data
    })
  }
});

$('#admin_sale_wrapper table tbody').sortable({
  helper: fixHelper,
  stop: function(){
    $data = {};

    $('#admin_sale_wrapper table tbody tr').each(function(index, item){
      $data[$(item).data('id')] = index;
    });

    $.ajax({
      method: "PUT",
      url: '/products/sale/setorder',
      data: $data
    })
  }
});