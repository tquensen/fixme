<?php

function login($username, $password) {
    /** @var mysqli $db */
    global $db;
    $query = "select `id` from `users` where `username` = '{$db->real_escape_string($username)}' AND `password` = '{$db->real_escape_string($password)}'";
    $result = $db->query($query);
    if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
        $_SESSION['logged_in'] = true;
        $_SESSION['userid'] = $row['id'];
        return(true);
    }
    print('<div class="row"><div class="col-lg-12 text-center" style="color:#ff0000;">Login unsuccessful!</div></div>');
    return(false);
}



print('<div class="container">');


if (logged_in() || (isset($_POST['username']) && isset($_POST['password']) && login($_POST['username'], $_POST['password']))) {
    $id = $_SESSION['userid'];
    global $db;
    $query = "select * from `users` where `id` = '{$db->real_escape_string($id)}' LIMIT 1";
    $result = $db->query($query);
    if ($row = $result->fetch_assoc()) {
        $username = $row['username'];
    } else {
        print('<div class="row"><div class="col-lg-12 text-center" style="color:#ff0000;">Login unsuccessful!</div></div>');
    }

    print('<div class="row">
            <div class="col-lg-12 text-center">
                <h1>Private Area</h1>
                Hey ' . htmlspecialchars($username) . '. Nice to have you here!
            <p>
                <a class="btn btn-danger" href="?site=logout.php">Logout</a>
            </p>
            </div>
        </div>
        <!-- /.row -->
    ');
} else {
    print('<div class="row">
            <div class="col-lg-offset-3 col-lg-6 text-center">
                <h1>Login</h1>
                <br />
                <form class="form-horizontal" action="#" method="POST">
                  <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input name="loggedin" id="loggedin" type="checkbox" checked="checked"> Remember me
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Sign in</button>
                    </div>
                  </div>
                </form>
                </div>
            </div>
            <!-- /.row -->');
}

print('
    </div>
    <!-- /.container -->');

?>
