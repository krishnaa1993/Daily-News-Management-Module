<?php
include 'db.php';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$news = [];
if($id){
    $res = $conn->query("SELECT * FROM daily_news WHERE News_Id=$id");
    $news = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $id ? 'Edit News' : 'Add News'; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
<h2><?php echo $id ? 'Edit News' : 'Add News'; ?></h2>
<form id="newsForm" enctype="multipart/form-data">
    <input type="hidden" name="News_Id" value="<?php echo $news['News_Id'] ?? ''; ?>">

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="News_Title" class="form-control" required value="<?php echo $news['News_Title'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="News_Description" class="form-control" required><?php echo $news['News_Description'] ?? ''; ?></textarea>
    </div>

    <div class="mb-3">
        <label>Banner Image</label>
        <input type="file" name="News_Banner_Image" class="form-control">
        <?php if(isset($news['News_Banner_Image']) && $news['News_Banner_Image'] != ''): ?>
            <img src="assets/uploads/<?php echo $news['News_Banner_Image']; ?>" width="100">
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label>Category</label>
        <input type="text" name="Category" class="form-control" required value="<?php echo $news['Category'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="News_Date" class="form-control" required value="<?php echo $news['News_Date'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Region</label>
        <input type="text" name="Region" class="form-control" value="<?php echo $news['Region'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Language</label>
        <input type="text" name="Language" class="form-control" value="<?php echo $news['Language'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>City</label>
        <input type="text" name="City" class="form-control" value="<?php echo $news['City'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Country</label>
        <input type="text" name="Country" class="form-control" value="<?php echo $news['Country'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="Status" class="form-control">
            <option value="Active" <?php if(($news['Status'] ?? '')=='Active') echo 'selected'; ?>>Active</option>
            <option value="Inactive" <?php if(($news['Status'] ?? '')=='Inactive') echo 'selected'; ?>>Inactive</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Is Active</label>
        <select name="IsActive" class="form-control">
            <option value="1" <?php if(($news['IsActive'] ?? 1)==1) echo 'selected'; ?>>Yes</option>
            <option value="0" <?php if(($news['IsActive'] ?? 1)==0) echo 'selected'; ?>>No</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success"><?php echo $id ? 'Update' : 'Add'; ?></button>
    <a href="index.php" class="btn btn-secondary">Back</a>
</form>

<script>
$('#newsForm').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('action', '<?php echo $id ? "update" : "add"; ?>');
    $.ajax({
        url: 'ajax_news.php',
        type: 'POST',
        data: formData,
        contentType:false,
        processData:false,
        success:function(resp){
            alert(resp);
            window.location='index.php';
        }
    });
});
</script>
</body>
</html>
