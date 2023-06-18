<?php
// Do some complex form validation
// https://www.w3schools.com/php/php_form_validation.asp

// Using filters
// https://www.w3schools.com/php/php_filter.asp

const REQUIRED_FIELD_ERROR = 'This field is required';


$errors = [];
$username = '';
$email = '';
$password = '';
$password_confirm = '';
$cv_url = '';
$postData = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = post_data('username');
    $email = post_data('email');
    $password = post_data('password');
    $password_confirm = post_data('password_confirm');
    $cv_url = post_data('cv_url');

    if (!$username) {
        $errors['username'] = REQUIRED_FIELD_ERROR;
    } else if (strlen($username) < 6 || strlen($username) > 16){
        $errors['username'] = 'Username must be less than 16 and more than 6 chars';
        }
        if (!$email) {
            $errors['email'] = REQUIRED_FIELD_ERROR;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Please enter valid email address';
        }
        if (!$password) {
            $errors['password'] = REQUIRED_FIELD_ERROR;
        }
        if (!$password_confirm) {
            $errors['password_confirm'] = REQUIRED_FIELD_ERROR;
        }
        if ($password && $password_confirm && strcmp($password, $password_confirm) !== 0){
            $errors['password_confirm'] = 'Please repeat the password correctly';
        }
        if ($cv_url && !filter_var($cv_url, FILTER_VALIDATE_URL) || $cv_url == '') {
            $errors['cv_url'] = 'Please provide a valid link address';
        }
}

function post_data($field)
{
    if (!isset($_POST[$field])) {
    return false;
}
    $data = $_POST[$field];
    if (is_array($data)) {
        $data = array_map(function ($d) {
        return htmlspecialchars(stripslashes(trim($d)));
    }, $data);
    } else if (is_string($data)) {
        $data = htmlspecialchars(stripslashes(trim($data)));
    }
        return $data;
}
var_dump($_POST);

?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/register.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
            <section class="form-flex">
                <div class="form-input-div">
                    <label>Username</label>
                    <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>"
                           name="username" value="<?php echo $username ?>">
                    <small class="form-text text-muted">Min: 6 and max 16 characters</small>
                    <div class="invalid-feedback">
                        <?php echo isset($errors['username']) ? $errors['username'] : '' ?>
                    </div>
                </div>
                <div class="form-input-div">
                    <label>Email</label>
                    <input class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : '' ?>"
                           name="email" value="<?php echo $email ?>">
                    <div class="invalid-feedback">
                        <?php echo isset($errors['email']) ? $errors['email'] : '' ?>
                    </div>
                </div>
                <div class="form-input-div">
                    <label>Password
                    </label>
                    <input class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>"
                           name="password" value="<?php echo $password ?>">
                    <div class="invalid-feedback">
                        <?php echo isset($errors['password']) ? $errors['password'] : '' ?>
                    </div>
                </div>
                <div class="form-input-div">
                    <label>Confirm Password</label>
                    <input class="form-control <?php echo isset($errors['password_confirm']) ? 'is-invalid' : '' ?>"
                           name="password_confirm" value="<?php echo $password_confirm ?>">
                    <div class="invalid-feedback">
                        <?php echo isset($errors['password_confirm']) ? $errors['password_confirm'] : '' ?>
                    </div>
                </div>
                <div class="form-input-div">
                    <label>CV link</label>
                    <input type="text" class="form-control <?php echo isset($errors['cv_url']) ? 'is-invalid' : '' ?>"
                           name="cv_url" placeholder="https://www.example.com/my-cv" value="<?php echo $cv_url ?>"/>
                    <div class="invalid-feedback">
                        <?php echo isset($errors['cv_url']) ? $errors['cv_url'] : '' ?>
                    </div>
                </div>
                <div class="form-input-div">
                    <button class="btn-confirm">Register</button>
                </div>
            </section>
        </form>
    </div>
</body>
</html>
