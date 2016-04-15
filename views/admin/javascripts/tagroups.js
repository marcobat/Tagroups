(function ($) {
  function isAnArray(o) {
    return Object.prototype.toString.call(o) === '[object Array]'; 
  }
  $( document ).ready(function() {
    function tags_to_add(tagitem) {
      var tagsToAddValue = $('#tags-to-add').val();
      if (tagsToAddValue == '') {
        $('#tags-to-add').val($(tagitem).find('.tag').text());
      } else {
        $('#tags-to-add').val(tagsToAddValue + ',' + $(tagitem).find('.tag').text());
      }
    }
    if (isAnArray( tagList )) {
      var tmpIndex = -1;
      if ($('#add-tags').length != 0) {
        $("#tag-form").append('<div id="tags-all-tags"><h3>Add Tags</h3><p>Click on any of the following tags to add it to this item. Remember to "Save Changes" to save your modifications.</p></div>');
        $("#add-tags").detach().appendTo('#tag-form');
        $('#all-tags h3:first-child').replaceWith('<h3>Current Tags</h3>');
        
        var tagshtml = '<div class="tag-list-unused">';
        for (var orgTag in organizedTags) {
          tagshtml += '<h3>' + orgTag + '</h3>';
          tagshtml += '<ul>';
          for (var t=0; t < organizedTags[orgTag].length; t++) {
            tmpIndex = tagList.indexOf(organizedTags[orgTag][t]);
            if (tmpIndex >= 0) {
              tagList.splice(tmpIndex,1);
            }
            if (itemTags.indexOf(organizedTags[orgTag][t]) == -1) {
              tagshtml += '<li class="added-not"><span class="tag">' + organizedTags[orgTag][t] + '</span><span class="add-tag"><a href="#">Add</a></span></li>';
            }
          }
          tagshtml += '</ul>';
		}
		
		if (tagList.length > 0) {
          tagshtml += '<h3>Previously used but not yet organized Tags</h3>';
          tagshtml += '<ul>';
          for (var t=0; t < tagList.length; t++) {
            if (itemTags.indexOf(tagList[t]) == -1) {
              tagshtml += '<li class="added-not"><span class="tag">' + tagList[t] + '</span><span class="add-tag"><a href="#">Add</a></span></li>';
            }
          }
          tagshtml += '</ul>';
		}
        tagshtml += '</div>';
        $('#tags-all-tags').append(tagshtml);
      }
      $('#tags-all-tags li').click(function(){
        tags_to_add($(this));
        $(this).removeClass('added-not');
        $('ul#all-tags-list').append('<li class="to-be-added"><span class="tag">' + $(this).find('.tag').text() + '</span></li>');
      });
      $('#add-tags').prepend('<h3>Add New Tags</h3>');
    }
  })
})(jQuery);