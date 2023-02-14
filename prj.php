<!DOCTYPE html>
<!-- prj.php - Processes the search form described in prj.html
     -->
<html lang = "en">
    <head>
        <title> Search Results </title>
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
        $search = $_POST["search"];
        $title = $_POST["title"];
        $author = $_POST["author"];
        $minWords = $_POST["minWords"];
        $maxWords = $_POST["maxWords"];
        $order = $_POST["order"];
        $terms = explode(", ", $search);

        // Update poular searches table
        foreach ($terms as $value) {
            if ($value != "") {
                $query = "SELECT * FROM PopSearches WHERE SearchTerm='" . $value . "'";
                $result = $db -> query($query);
                if ($row = $result -> fetch_row()) {
                    $query = "UPDATE PopSearches SET NumSearches=" . ++$row[1] . " WHERE SearchTerm='" . $value . "'";
                    $db -> query($query);
                }
                else {
                    $query = "INSERT INTO PopSearches VALUES ('" . $value . "', 1)";
                    $db -> query($query);
                }
            }
        }
        if ($title != "") {
            $query = "SELECT * FROM PopSearches WHERE SearchTerm='" . $title . "'";
            $result = $db -> query($query);
            if ($row = $result -> fetch_row()) {
                $query = "UPDATE PopSearches SET NumSearches=" . ++$row[1] . " WHERE SearchTerm='" . $title . "'";
                $db -> query($query);
            }
            else {
                $query = "INSERT INTO PopSearches VALUES ('" . $title . "', 1)";
                $db -> query($query);
            }
        }
        if ($author != "") {
            $query = "SELECT * FROM PopSearches WHERE SearchTerm='" . $author . "'";
            $result = $db -> query($query);
            if ($row = $result -> fetch_row()) {
                $query = "UPDATE PopSearches SET NumSearches=" . ++$row[1] . " WHERE SearchTerm='" . $author . "'";
                $db -> query($query);
            }
            else {
                $query = "INSERT INTO PopSearches VALUES ('" . $author . "', 1)";
                $db -> query($query);
            }
        }

        // Create query statement
        $query = "SELECT Title, Author, PubDate, WordCount, Summary, Link FROM FanficData WHERE";
        // Add keywords to query
        foreach ($terms as $value) {
            if ($value != "") {
                $query .= " (Keywords LIKE '%" . $value . ",%' OR Keywords LIKE '%" . $value . "') AND";
            }
        }
        // Add word count constraints to query
        if (is_numeric($minWords)) {
            $query .= " WordCount>=" . $minWords . " AND";
        }
        if (is_numeric($maxWords)) {
            $query .= " WordCount<=" . $maxWords . " AND";
        }
        // Add work title constraint to query
        if ($title != "") {
            $query .= " Title LIKE '%" . $title . "%' AND";
        }
        // Add author name constraint to query
        if ($author != "") {
            $query .= " Author LIKE '%" . $author . "%' AND";
        }
        // Add do-nothing conditional to end WHERE segment of the query with correct syntax
        $query .= " 1";
        // Add order of results to query
        if ($order == "author") {
            $query .= " ORDER BY Author ASC";
        }
        elseif ($order == "length") {
            $query .= " ORDER BY WordCount DESC";
        }
        else {
            $query .= " ORDER BY Title ASC";
        }

        // Execute query statement
        $result = $db -> query($query);
        if (!$result) {
            print "Error - Query failed to execute";
            exit;
        }

        // Display the results
        print "<table style='width: 100%;'><caption><h2>Search Results:</h2></caption><tr><th>Title</th><th>Author</th><th>Date Posted</th><th>Word Count</th><th>Summary</th><th>Link to Work</th></tr>";
        while ($row = $result -> fetch_row()) {
            print "<tr>";
            for ($index = 0; $index < 5; $index++) {
                print "<td>" . $row[$index] . "</td>";
            }
            print "<td><a href=\"" . $row[5] . "\">Link</a></td>";
            print "</tr>";
        }
        print "</table>";

        // Find and recommend some popular search terms
        $query = "SELECT * FROM PopSearches ORDER BY NumSearches DESC LIMIT 3";
        $result = $db -> query($query);
        print "<table><Caption><h4 style='text-align: left;'>Popular searches to try next:</h4></caption><tr>";
        while ($row = $result -> fetch_row()) {
            print "<td>" . $row[0] . "</td>";
        }
        print "</tr></table>";
        ?>
    </body>
</html>
