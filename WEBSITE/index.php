<?php include_once("pages/template.php"); ?>
<!DOCTYPE html>
<html>
    <?=makeHead()?>
    <body>
        <script src="script/api.js"></script>
        <script src="script/checks/checkNotLoggedIn.js"></script>
        <?=makeHeader()?>
        <main class="container-fluid py-3">
            <div class="container p-4">
                <h2>Nos Actualités</h2>
                <img src="assets/actuality.jpeg" style="width: 100%;">

                <script src="script/api.js"></script>
                <script src="script/login.js"></script>

                <button onclick="test()">TEST</button>
            </div>
        </main>
        <?=makeFooter()?>
    </body>
</html>
