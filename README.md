Daily News Dashboard - Krishna Patil

Project Description:

The Daily News Dashboard is a simple, fully functional web application to manage news articles. It allows users to add, edit, delete, read, and search news based on title, category, status, region, city, and country. The dashboard supports image previews, pagination, and filtering for easy management.

Key Features:

Add news with title, description, banner image, category, date, region, language, city, country, status, and active flag. Edit existing news with real-time updates. Delete news safely with confirmation. Search by title or category. Filter news by status (Active / Inactive). Read full news in a modal with detailed info: category, region, language, city, country, date, status, who updated it, and last updated time. Image hover zoom effect for quick preview. This project is built using PHP, MySQL, jQuery, AJAX, and Bootstrap for responsive UI.

Installation Guide (Beginner-Friendly):

Follow these steps even if you know nothing about PHP:

Install XAMPP
Download and install XAMPP (includes Apache + MySQL + PHP). Open XAMPP Control Panel and start Apache and MySQL.

Setup the Project
Download this project folder and place it in C:\xampp\htdocs\ (or equivalent path). For example: C:\xampp\htdocs\daily-news-dashboard.

Create Database
Open phpMyAdmin: http://localhost/phpmyadmin Click Databases → create a database named daily_news_db. Import daily_news_db.sql if provided (contains the daily_news table).

Table columns:

News_Id (Primary Key) News_Title, News_Description, News_Banner_Image Category, News_Date, Status, Region, Language, City, Country UpdatedBy, UpdatedOn, IsActive

Configure Database Connection
Open db.php in the project.

Update these lines if needed:

$servername = "localhost"; $username = "root"; $password = ""; $dbname = "daily_news_db";

Usually, root with empty password works for default XAMPP.

Access the Dashboard
Open browser → go to: [http://localhost/DailyNewsModule/index.php] You should see the Daily News Dashboard with "Add News" button and table.

How to Use the Project:

Add News

Click Add News → fill all fields → upload image → click Add.

Edit News

Click Edit next to a news item → update info → click Update.

Delete News

Click Delete → confirm → news is removed.

Read News

Click Read → modal opens → see detailed info including region, city, country, language, status, date.

Search and Filter

Use search box to find news by title or category.

Use status dropdown to filter Active / Inactive news.

Technical Details:

Frontend: Bootstrap 5 + jQuery + AJAX for dynamic table and modal. Backend: PHP for CRUD operations. Database: MySQL with daily_news table. File Uploads: Banner images stored in assets/uploads/. Pagination: Shows 5 news per page, automatic page links. Hover Effect: Banner image zooms on hover.

Notes: Country and Region fields help track where news is from. UpdatedBy and UpdatedOn fields track who last edited the news and when. Supports multiple languages and regions.

daily-news-dashboard/ │ ├─ assets/ │ ├─ css/ │ │ └─ bootstrap.min.css │ ├─ js/ │ │ ├─ bootstrap.bundle.min.js │ │ └─ jquery.min.js │ └─ uploads/ # Folder to store news images │ ├─ ajax_news.php # AJAX handler for CRUD operations ├─ db.php # Database connection ├─ index.php # Dashboard listing all news ├─ news_form.php # Add/Edit News form └─ README.md

Author Krishna Patil
