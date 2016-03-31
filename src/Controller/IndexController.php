<?php
namespace Controller;

use Doctrine\DBAL\Query\QueryBuilder;

class IndexController
{
    public function indexAction()
    {
        //include view
        include("../views/search.php");
    }

    public function searchAction()
    {
        //se connecter à la bdd
        header('Content-Type: application/json');


        $conn = \MovieSearch\Connexion::getInstance();


        /**/
        $title = $_POST['title'];
        $duration = $_POST['duration'];
        $yearStart = $_POST['year_start'];
        $yearEnd = $_POST['year_end'];
        $gender = $_POST['gender'];
        $author = $_POST['author'];

        if (!empty($author)) {
            $sqlAuthor = "SELECT * FROM artist INNER JOIN film_director ON film_director.artist_id = artist.id INNER JOIN film ON film.id = film_director.film_id WHERE last_name=:last_name";
            $stmt3 = $conn->prepare($sqlAuthor);
            $stmt3->bindParam("last_name", $author);
            $stmt3->execute();
            $artistName = $stmt3->fetchAll();
            return json_encode(["artistName" => $artistName]);
        }

        if (!empty($gender) && $gender == 'm' || $gender == 'M' || $gender == 'f' || $gender == 'F') {
            $sqlGender = "SELECT * FROM artist INNER JOIN film_director ON film_director.artist_id = artist.id INNER JOIN film ON film.id = film_director.film_id WHERE gender=:gender";
            $stmt2 = $conn->prepare($sqlGender);
            $stmt2->bindParam("gender", $gender);
            $stmt2->execute();
            $artistGender = $stmt2->fetchAll();
            return json_encode(["artist" => $artistGender]);
        }
        if (isset($title)) {
            $sqlTitle = " SELECT * FROM film_director
                          INNER JOIN artist AS a
                          ON artist_id = a.id
                          INNER JOIN film AS f
                          ON film_director.film_id = f.id
                          WHERE f.title
                          LIKE '%$title%' ";
        }

        if (isset($duration)) {
            if ($duration == "all") {
                $sqlDuration = "";

            } else if ($duration == "lessHour") {
                $sqlDuration = " AND duration < 3600";

            } else if ($duration == "between1Hour") {
                $sqlDuration = " AND duration BETWEEN 3600 AND 5400 ";

            } else if ($duration == "between2Hour") {
                $sqlDuration = " AND duration BETWEEN 5400 AND 9000 ";

            } else if ($duration == "moreHour") {
                $sqlDuration = " AND duration > 9000 ";
            }
        }

        if (isset($yearStart)) {
            $sqlYearStart = " AND year >= '$yearStart' ";
        }

        if (empty($yearStart)) {
            $sqlYearStart = "";
        }

        if (isset($yearEnd)) {
            $sqlYearEnd = " AND year <= '$yearEnd' ";
        }

        if (empty($yearEnd)) {
            $sqlYearEnd = "";
        }
        //.'GROUP BY title'

        $stmt = $conn->prepare($sqlTitle . $sqlDuration . $sqlYearStart . $sqlYearEnd . 'GROUP BY title');
        $stmt->execute();
        $films = $stmt->fetchAll();
        return json_encode(["films" => $films]);
    }
}