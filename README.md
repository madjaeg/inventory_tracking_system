# inventory_tracking_system

Inventory tracking system that allows users to request and restock items, add new items, and delete items that are at a stock number of 0 from the list. Records all changes made to the list using another MySQL database, Change Log.

Built using primarily PHP with a MySQL database. Also utilizes some jQuery and HTML5 for form validation.
All forms are validated and sticky (save for dynamically filled drop downs) using PHP session variables and a PHP redirect function.

Font Awesome was used for the icons on error and success messages.

Don't forget to fill in your database's information in the mysqli_connect.php file, and on the various pages:</br>
index.php<br/>
request.php<br/>
request-validate.php<br/>
restock.php<br/>
restock-validate.php<br/>
add-validate.php<br/>
out-of-stock.php<br/>
out-validate.php<br/>
change-log.php<br/>
grab-num-in-stock.php<br/>

----------------------------------------------

index.php<br/>
-Shows all items in the list, except for any items with a stock number of 0.<br/>
-Any item that has a stock number below 50 is considered low in stock, and is colored in red on the home page. This can be altered in the javascript.js file, line 10.<br/>

request.php<br/>
-Form that allows a user to request an item that is already in the inventory list. Will prompt if there is an issue with any info entered.<br/>
-Only items with a stock number above 0 are available in the dropdown.<br/>

restock.php<br/>
-Form that allows a user to restock an item that is already in the inventory list. Will prompt if there is an issue with any info entered.<br/>
-The dropdown includes items that have a stock number of 0, so that a user can opt to bring back the items from the Out of Stock table, and back into the regular Inventory list.<br/>

add-items.php<br/>
-Form that allows a user to add a new item to the inventory list. Item cannot already exist in the list; the form will prompt if there is an issue with any info entered.<br/>

out-of-stock.php<br/>
-Table where all items that have dropped to a stock number of 0 go.<br/>
-Users are only allowed to delete an item from the list if the stock number drops to 0--aka, if the item is on the Out of Stock table.<br/>
-Will prompt the user for a name, so that the deletion can be recorded in Change Log properly.<br/>

change-log.php<br/>
-Seperate MySQL database table that lists all changes that have been made to the inventory list. Tracks names, item names, number in stock, amount changes, updated number in stock, events, and date/time.<br/>
-Is paginated; shows 20 entires per page. This can be altered in change-log.php on line 17.<br/>
