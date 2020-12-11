<?php

print('<div class="container">');
print('<div class="row">
            <div class="col-lg-12 text-center">
                <h1>Guestbook</h1>
            </div>
        </div>
        <!-- /.row -->
    ');

global $db;

if(isset($_POST['entry']) && $_POST['entry'] != "") {
    $id = $_SESSION['userid'];
    $entry = $_POST['entry'];
    $query = "select * from `users` where `id` = '{$db->real_escape_string($id)}' LIMIT 1";
    $result = $db->query($query);
    if ($row = $result->fetch_assoc()) {
        $username = $row['username'];
    }
    $query = "INSERT INTO `guestbook` (`username`, `entry`) VALUES ('{$db->real_escape_string($username)}', '{$db->real_escape_string($entry)}');";
    $result = $db->query($query);
    $db->commit();
    print('<div class="row">
            <div class="col-lg-12 text-center">
                Your entry was recorded.
            </div>
        </div>');
}

$id = $_SESSION['userid'];
$query = "select * from `guestbook` ORDER BY `id` DESC";
$result = $db->query($query);
if ($result->num_rows > 0) {
    print('<table class="table table-striped table-responsive"><thead><tr><th>Author</th><th>Entry</th></tr></thead><tbody>');
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $entry = $row['entry'];
        print('<tr><td>' . htmlspecialchars($username) . '</td><td>' . htmlspecialchars($entry) . '</td></tr>');
    }
    print('</tbody></table>');
} else {
    print('<div class="row">
            <div class="col-lg-12 text-center">
                Sorry. There is nothing here!
            </div>
        </div>
        <!-- /.row -->
    ');
}

if(logged_in()) {
    print('<div class="row">
            <div class="col-lg-12 text-center">
    <form action="#" method="POST">
    <textarea class="form-control" rows="4" cols="50" name="entry" id="entry" value="entry" label="entry" placeholder="My entry ..."></textarea><br />
    <input class="btn btn-default" type="submit" name="submit" id="submit" value="submit" label="submit" />
    </form>
            </div>
        </div>
        <!-- /.row -->
    ');
} else {
    print('<div class="row">
            <div class="col-lg-12 text-center">
                Sorry. You need to log in to write something.
            </div>
        </div>
        <!-- /.row -->
    ');
}


print('
    </div>
    <!-- /.container -->');

?>