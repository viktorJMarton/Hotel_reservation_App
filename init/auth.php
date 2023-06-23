<?php
session_start();

// Bejelentkezési állapot ellenőrzése
function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}
// Felhasználó bejelentkeztetése
function login($username, $password) {
    // Ellenőrizd a felhasználónevet és jelszót a megfelelő adatbázisból vagy más tárolóból
    // ...

    // Ha az adatok helyesek
    if ($valid) {
        $_SESSION['username'] = $username;
        // További adatokat is tárolhatsz a munkamenetben

        return true;
    } else {
        return false;
    }
}

// Kijelentkezés
function logout() {
    session_destroy();
}
?>
