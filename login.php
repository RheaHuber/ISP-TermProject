<!DOCTYPE html>
<!-- login.php - Processes the administrator login form from prj.html and 
     describes a form for administrators to edit the FanficData table entries
     -->
<html lang = "en">
    <head>
        <title> Admin Table Editor </title>
        <meta charset = "utf-8" />
        <style type = "text/css">
            td, th, table {
                border: thin solid black;
            }
            td, th, tr {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
        // Connect to database
        $host = "localhost:3306";
        $username = "root";
        $password = "";
        $dbName = "fanfiction";

        $db = new mysqli($host, $username, $password, $dbName);
        if ($db -> connect_errno) {
            print "Error - Could not connect to MySQL";
            exit;
        }

        // Get search terms and constraints
        $usrnm = $_POST["username"];
        $pwd = $_POST["password"];

        // Create query statement
        $query = "SELECT * FROM Users WHERE Username='" . $usrnm . "'";

        // Execute query statement
        $result = $db -> query($query);
        if (!$result) {
            print "Error - Query failed to execute";
            exit;
        }

        // Check password and admin
        if ($row = $result -> fetch_row()) {
            if ($row[2] != $pwd || $row[3] != 1) {
                print "Username or password was incorrect";
                exit;
            }
        }
        else {
            print "Username or password was incorrect";
            exit;
        }
        ?>
        <form action="http://localhost/isp/prj/editor.php" method="post">
            <h3>Fanfiction Table Editor</h3>
            <!-- Specify Element values -->
            <br /><label for="title">Work Title:</label><br />
            <input type="text" name="title" />
            <br /><label for="author">Author Name:</label><br />
            <input type="text" name="author" />
            <hr /><label for="pubDate">Date Published (MM/DD/YYYY):</label><br />
            <input type="text" name="pubDate" />
            <br /><label for="wordCount">Word Count:</label><br />
            <input type="number" name="wordCount" />
            <br /><label for="summary">Summary:</label><br />
            <input type="text" name="summary" />
            <br /><label for="keywords">Keywords:</label><br />
            <input type="text" name="keywords" />
            <br /><label for="link">Link to Work:</label><br />
            <input type="text" name="link" />

            <!-- Choose type of query to execute -->
            <br /><br /><label for="type">Query Type:</label><br />
            <select name="type">
                <option value="insert">INSERT</option>
                <option value="update">UPDATE</option>
                <option value="delete">DELETE</option>
            </select>

            <!-- The submit and reset buttons -->
            <p>
                <input type="submit" value="Execute" />
                <input type="reset" value="Clear" />
            </p>
        </form>
    </body>
</html>
