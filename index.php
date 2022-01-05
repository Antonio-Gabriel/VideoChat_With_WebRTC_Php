<?php
    echo "Server";
?>

<script>
    var conn = new WebSocket('ws://localhost:8090');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        console.log(e.data);
    };
</script>