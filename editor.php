<!DOCTYPE html>
<!-- editor.php - Processes the form described in login.php
     -->
<html lang = "en">
    <head>
        <title> Query Results </title>
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
            $title = $_POST["title"];
            $author = $_POST["author"];
            $pubDate = $_POST["pubDate"];
            $wordCount = $_POST["wordCount"];
            $summary = $_POST["summary"];
            $keywords = $_POST["keywords"];
            $link = $_POST["link"];
            $type = $_POST["type"];

            // Create query statement
            $query = "";
            if ($type == "update") {
                // Create UPDATE query
                if ($title == "" || $author == "") {
                    print "Title and Author required for UPDATE query";
                    exit;
                }
                if ($pubDate == "" && !is_numeric($wordCount) && $summary == "" && $keywords == "" && $link == "") {
                    print "Some field required for UPDATE query";
                    exit;
                }
                $query = "UPDATE FanficData SET ";
                if ($pubDate != "") {
                    $query .= "PubDate='" . $pubDate . "', ";
                }
                if (is_numeric($wordCount)) {
                    $query .= "WordCount=" . $wordCount . ", ";
                }
                if ($summary != "") {
                    $query .= "Summary='" . $summary . "', ";
                }
                if ($keywords != "") {
                    $query .= "Keywords='" . $keywords . "', ";
                }
                if ($link != "") {
                    $query .= "Link='" . $link . "', ";
                }
                // Add a do-nothing SET to end that segment of the query with correct syntax
                $query .= "Title='" . $title . "' WHERE Title='" . $title . "' AND Author='" . $author . "'";
            }
            elseif ($type == "delete") {
                // Create DELETE query
                if ($title == "" || $author == "") {
                    print "Title and Author required for DELETE query";
                    exit;
                }
                $query = "DELETE FROM FanficData WHERE Title='" . $title . "' AND Author='" . $author . "'";
            }
            else {
                // Create INSERT query
                if ($title == "" || $author == "" || $pubDate == "" || !is_numeric($wordCount) || $summary == "" || $keywords == "" || $link == "") {
                    print "All fields required for INSERT query";
                    exit;
                }
                $query = "INSERT INTO FanficData VALUES (NULL, '" . $title . "', '" . $author . "', '" . $pubDate . "', " . $wordCount . ", '" . $summary . "', '" . $keywords . "', '" . $link . "')";
            }

            // Execute query statement
            $result = $db -> query($query);
            if (!$result) {
                print "Error - Query failed to execute";
                exit;
            }

            // Display the results
            print $query;
            print "\nQuery executed successfully";
        ?>
    </body>
</html>
