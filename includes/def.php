<?php

require('sendgrid-php/sendgrid-php.php');

function starRating($given) {
    $rating = "";
    for($i = 0; $i < $given; $i++) {
        $rating .= "<i class=\"fa fa-star\"></i>";
    }
    if ($given < 5) {
        for($i = 0; $i < 5-$given; $i++) {
            $rating .= "<i class=\"fa fa-star inactive\"></i>";
        }
    }
    return $rating;
}

function movieArray($id) {
    global $connection;
    $sql = "SELECT * FROM movies WHERE id='$id'";
    $result = $connection->query($sql);
    return mysqli_fetch_array($result,MYSQLI_ASSOC);
}

function theatreArray($theatre) {
    global $connection;
    $theatreSQL = "SELECT * FROM theatres WHERE name='$theatre'";
    $theatreResult = $connection->query($theatreSQL);
    return mysqli_fetch_array($theatreResult,MYSQLI_ASSOC);
}

function orderMail($username,$name,$movie,$theatre,$address,$date,$time,$seats,$price) {
    global $connection;
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $connection->query($sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $emailAddress = $row['email'];

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("info@veloxgroup.ca", "TicketSeatCity");
    $email->setSubject("Your TicketSeatCity Order Confirmation");
    $email->addTo($emailAddress, $name);
    $email->addContent(
        "text/html", "<h2>Order Confirmation</h2>
            <p>Name: ".$name."</p>
            <p>Movie: ".$movie."</p>
            <p>Theatre: ".$theatre."</p>
            <p>Address: ".$address."</p>
            <p>Date: ".$date."</p>
            <p>Time: ".$time."</p>
            <p>Seats: ".$seats."</p>
            <p>Total Price: ".$price."</p>"
    );
    $sendgrid = new \SendGrid('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');
    try {
        $sendgrid->send($email);
    } catch (Exception $e) {
        die('Caught exception: '. $e->getMessage() ."\n");
    }


}