<?php 

    include '../../php/database.php';

    extract($_GET);

    session_start();

    // Vérifier si l'email et le mot de passe existes et sont correctes
    $stmt = $db->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(['email' => $email]); 
    $data = $stmt->fetch(PDO::FETCH_BOTH);

    if (isset($data['passwd'])) {

        $current_password = $data['passwd'];
        $send_password = hash('sha512', $password);

        if (strcmp($current_password, $send_password) == 0) {
            $_SESSION['user-id'] = $data['id'];

            $stmt = $db->prepare("UPDATE users SET isOnline=1 WHERE id=:id");
            $stmt->execute(['id' => $_SESSION['user-id']]);

            echo 'success';
        } else {
            echo 'error';
        }

    } else {
        echo 'error';
    }
    
?>