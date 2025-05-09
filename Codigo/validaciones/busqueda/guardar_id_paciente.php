<?php
session_start();

if (isset($_POST['id'])) {
    $_SESSION['idPaciente'] = intval($_POST['id']);
    echo 'ok';
}
