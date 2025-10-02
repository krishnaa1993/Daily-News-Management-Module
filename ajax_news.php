<?php
include 'db.php';

$action = $_POST['action'] ?? '';

if($action=='fetch'){
    $search = $_POST['search'] ?? '';
    $status = $_POST['status'] ?? '';
    $page = $_POST['page'] ?? 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    // Count total records
    $count_query = "SELECT COUNT(*) as total FROM daily_news 
                    WHERE (News_Title LIKE '%$search%' OR Category LIKE '%$search%')";
    if($status != '') $count_query .= " AND Status='$status'";
    $total_res = $conn->query($count_query);
    $total_row = $total_res->fetch_assoc();
    $total_pages = ceil($total_row['total'] / $limit);

    // Fetch records
    $query = "SELECT * FROM daily_news 
              WHERE (News_Title LIKE '%$search%' OR Category LIKE '%$search%')";
    if($status != '') $query .= " AND Status='$status'";
    $query .= " ORDER BY News_Date DESC LIMIT $limit OFFSET $offset";
    $res = $conn->query($query);

    echo '<table class="table table-bordered">
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Category</th>
        <th>Date</th>
        <th>Status</th>
        <th>Updated By</th>
        <th>Updated On</th>
        <th>IsActive</th>
        <th>Actions</th>
    </tr>';

    while($row=$res->fetch_assoc()){
        $img = $row['News_Banner_Image'] ? "<div class='news-image-container'><img src='assets/uploads/".$row['News_Banner_Image']."'></div>" : '';
        echo '<tr>
            <td>'.$img.'</td>
            <td>'.$row['News_Title'].'</td>
            <td>'.$row['Category'].'</td>
            <td>'.$row['News_Date'].'</td>
            <td>'.$row['Status'].'</td>
            <td>'.$row['UpdatedBy'].'</td>
            <td>'.$row['UpdatedOn'].'</td>
            <td>'.($row['IsActive'] ? 'Yes' : 'No').'</td>
            <td>
                <a href="news_form.php?id='.$row['News_Id'].'" class="btn btn-sm btn-primary">Edit</a>
                <button class="btn btn-sm btn-danger delete_news" data-id="'.$row['News_Id'].'">Delete</button>
                <button class="btn btn-sm btn-info read_news"
                    data-title="'.htmlspecialchars($row['News_Title']).'"
                    data-img="'.$row['News_Banner_Image'].'"
                    data-desc="'.htmlspecialchars($row['News_Description']).'"
                    data-category="'.htmlspecialchars($row['Category']).'"
                    data-region="'.htmlspecialchars($row['Region']).'"
                    data-language="'.htmlspecialchars($row['Language']).'"
                    data-city="'.htmlspecialchars($row['City']).'"
                    data-country="'.htmlspecialchars($row['Country']).'"
                    data-date="'.$row['News_Date'].'"
                    data-status="'.$row['Status'].'"
                    data-updatedby="'.htmlspecialchars($row['UpdatedBy']).'"
                    data-updatedon="'.$row['UpdatedOn'].'"
                    data-isactive="'.$row['IsActive'].'"
                >Read</button>
            </td>
        </tr>';
    }
    echo '</table>';

    // Pagination
    echo '<nav><ul class="pagination">';
    if($page > 1) echo '<li class="page-item"><a class="page-link" href="#" data-page="'.($page-1).'">Previous</a></li>';
    for($i=1; $i<=$total_pages; $i++){
        $active = ($i==$page) ? 'active' : '';
        echo '<li class="page-item '.$active.'"><a class="page-link" href="#" data-page="'.$i.'">'.$i.'</a></li>';
    }
    if($page < $total_pages) echo '<li class="page-item"><a class="page-link" href="#" data-page="'.($page+1).'">Next</a></li>';
    echo '</ul></nav>';
}

// Add or Update
if($action=='add' || $action=='update'){
    $id = $_POST['News_Id'] ?? 0;
    $title = $_POST['News_Title'];
    $desc = $_POST['News_Description'];
    $category = $_POST['Category'];
    $date = $_POST['News_Date'];
    $status = $_POST['Status'] ?? 'Active';
    $region = $_POST['Region'] ?? '';
    $language = $_POST['Language'] ?? '';
    $city = $_POST['City'] ?? '';
    $country = $_POST['Country'] ?? '';
    $updatedBy = 'Admin'; // Change dynamically as needed
    $updatedOn = date('Y-m-d H:i:s');
    $isActive = $_POST['IsActive'] ?? 1;

    $fileName = '';
    if(isset($_FILES['News_Banner_Image']) && $_FILES['News_Banner_Image']['name']!=''){
        $allowed = ['jpg','jpeg','png','gif'];
        $ext = pathinfo($_FILES['News_Banner_Image']['name'], PATHINFO_EXTENSION);
        if(!in_array(strtolower($ext), $allowed)){ echo "Invalid file type"; exit; }
        if($_FILES['News_Banner_Image']['size'] > 5*1024*1024){ echo "File too large"; exit; }

        $fileName = time().'_'.$_FILES['News_Banner_Image']['name'];
        move_uploaded_file($_FILES['News_Banner_Image']['tmp_name'], 'assets/uploads/'.$fileName);
    }

    if($action=='add'){
        $sql = "INSERT INTO daily_news 
        (News_Title, News_Description, News_Banner_Image, Category, News_Date, Status, Region, Language, City, Country, UpdatedBy, UpdatedOn, IsActive)
        VALUES ('$title','$desc','$fileName','$category','$date','$status','$region','$language','$city','$country','$updatedBy','$updatedOn','$isActive')";
        echo $conn->query($sql) ? 'News Added Successfully' : 'Error';
    } else {
        $sql = "UPDATE daily_news SET 
                News_Title='$title', News_Description='$desc', Category='$category', News_Date='$date', Status='$status',
                Region='$region', Language='$language', City='$city', Country='$country', UpdatedBy='$updatedBy', UpdatedOn='$updatedOn', IsActive='$isActive'";
        if($fileName) $sql .= ", News_Banner_Image='$fileName'";
        $sql .= " WHERE News_Id=$id";
        echo $conn->query($sql) ? 'News Updated Successfully' : 'Error';
    }
}

// Delete
if($action=='delete'){
    $id = $_POST['id'];
    $conn->query("DELETE FROM daily_news WHERE News_Id=$id");
}
?>
