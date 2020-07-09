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
