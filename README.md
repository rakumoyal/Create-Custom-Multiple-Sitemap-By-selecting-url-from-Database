# Create-Custom-Multiple-Sitemap-By-selecting-url-from-Database

This Php script useful for creating a custom sitemap.xml after fetching URL from the database.

In this Repository, You have to just download the script and put it at the root of your project. One important thing, You have to create a folder "allsitemap" name with full writeable and readable permission(777). After this, you have to change the query as your wish and change the record strength in line 42(Increase it from 300 to any number.  Note: Max 50000 URL should be in per sitemap.xm file ) in sitemap.php and hit the URL: https://yourdomanin.com/sitemap.php 

This will create a sitemap.XML at root and parts of XML in allsitemap Folder. You have to give URL https://yourdomanin.com/sitemap.xml to Google For crawl the URLs.  
