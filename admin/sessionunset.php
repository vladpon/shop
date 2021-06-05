<?php
unset($_SESSION['cart']);
session_unset();
session_destroy();
// echo session_status();