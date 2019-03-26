<?php

class jiaScoket{
    protected $socket;
    protected $address;
    protected $port;
    protected $errors;
    protected $count = 10;

    function __construct($address, $port){
        if(($this->socket = socket_create ( AF_INET , SOCK_STREAM , SOL_TCP ))==false){
            $this->errors = "socket_create() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
            console.log($this->errors);
            exit;
        }
        echo "socket_create success \n";
        if (socket_bind($this->socket, $address, $port) === false) {
            $this->errors = "socket_bind() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
            console.log($this->errors);
            exit;
        }
        echo "socket_bind success \n";
        $this->address = $address;
        $this->port = $port;

        if (socket_listen($this->socket, $this->count) == false) {
            $this->errors = "socket_listen() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
            console.log($this->errors);
            exit;
        }
        echo "listening \n";
        while($this->count--){
            if(($myConnection = socket_accept($this->socket))==false){
                $this->errors = "socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->socket))."\n";
            }
            echo "there is a connected \n";
            $msg = "\nWelcome to the PHP Test Server. \n" .
            "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
            socket_write($myConnection, $msg, strlen($msg));
            while(1){
                $readMsg = socket_recv($myConnection, $readBuff, 2048, MSG_DONTWAIT);
                echo $readBuff;
            }
        }
        socket_close($myConnection);
    }

    function close(){
        socket_close($this->socket);
    } 

}
?>