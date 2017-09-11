<?php

$headers  = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "Return-Path: <atendimento@nuwaspa.com.br>\n";

$emailsender = "atendimento@nuwaspa.com.br";
$quebra_linha = "\n";

if(!mail("brunocesar@gmail.com", "teste", "teste ok", $headers ,"-r".$emailsender)){ // Se for Postfix
    $headers .= "Return-Path: " . $emailsender . $quebra_linha; // Se "não for Postfix"
    mail("brunocesar@gmail.com", "teste", "teste ok", $headers );
}

echo "Ok";

?>