<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Daily News Dashboard - Krishna Patil</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<style>
/* Image hover effect */
.news-image-container {
    width: 100px;
    height: 60px;
    overflow: visible;
    position: relative;
    cursor: pointer;
}

.news-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.news-image-container:hover img {
    transform: scale(2);
    position: absolute;
    top: -50px;
    left: -50px;
    z-index: 999;
    box-shadow: 0 0 15px rgba(0,0,0,0.5);
}
</style>
</head>
<body>
<div class="container mt-4">
    <h2>Daily News Dashboard - Krishna Patil</h2>
    <a href="news_form.php" class="btn btn-primary mb-3">Add News</a>
    
    <!-- Search -->
    <input type="text" id="search" placeholder="Search by Title or Category" class="form-control mb-3">
    <!-- Status Filter -->
    <select id="status_filter" class="form-control mb-3">
        <option value="">All Status</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>

    <!-- News Table -->
    <div id="news_table"></div>
</div>

<!-- Read Modal -->
<div class="modal fade" id="readModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="readTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <img id="readImage" src="" style="width:100%; height:auto;" class="mb-3">
        <p id="readDesc"></p>
        <p>
            <b>Category:</b> <span id="readCategory"></span> |
            <b>Region:</b> <span id="readRegion"></span> |
            <b>Language:</b> <span id="readLanguage"></span> |
            <b>City/Country:</b> <span id="readCity"></span>/<span id="readCountry"></span><br>
            <b>Date:</b> <span id="readDate"></span> |
            <b>Status:</b> <span id="readStatus"></span> |
            <b>Updated By:</b> <span id="readUpdatedBy"></span> |
            <b>Updated On:</b> <span id="readUpdatedOn"></span> |
            <b>IsActive:</b> <span id="readIsActive"></span>
        </p>
      </div>
    </div>
  </div>
</div>

<script>
function loadNews(query='', status='', page=1) {
    $.ajax({
        url: 'ajax_news.php',
        type: 'POST',
        data: {action:'fetch', search:query, status:status, page: page},
        success: function(data) {
            $('#news_table').html(data);
        }
    });
}

$(document).ready(function(){
    loadNews();

    $('#search').on('keyup', function(){
        loadNews($(this).val(), $('#status_filter').val());
    });

    $('#status_filter').on('change', function(){
        loadNews($('#search').val(), $(this).val());
    });

    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        loadNews($('#search').val(), $('#status_filter').val(), $(this).data('page'));
    });

    $(document).on('click', '.delete_news', function(){
        if(confirm('Are you sure?')){
            $.post('ajax_news.php', {action:'delete', id:$(this).data('id')}, function(){
                loadNews($('#search').val(), $('#status_filter').val());
            });
        }
    });

    // Read Button Click
    $(document).on('click', '.read_news', function(){
        $('#readTitle').text($(this).data('title'));
        $('#readImage').attr('src','assets/uploads/'+$(this).data('img'));
        $('#readDesc').text($(this).data('desc'));
        $('#readCategory').text($(this).data('category'));
        $('#readRegion').text($(this).data('region'));
        $('#readLanguage').text($(this).data('language'));
        $('#readCity').text($(this).data('city'));
        $('#readCountry').text($(this).data('country'));
        $('#readDate').text($(this).data('date'));
        $('#readStatus').text($(this).data('status'));
        $('#readUpdatedBy').text($(this).data('updatedby'));
        $('#readUpdatedOn').text($(this).data('updatedon'));
        $('#readIsActive').text($(this).data('isactive')==1?'Yes':'No');
        $('#readModal').modal('show');
    });
});
</script>
</body>
</html>
