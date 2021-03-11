<footer>
    <div class="container">
    <p <?php if($admin == false){echo 'hidden="true"';}?>><a style="text-decoration: none" class="text-muted" href="addnew.php">Hírek kezelése</a></p>
</footer>
<?php if(!isset($_SESSION['cookies'])) {echo'
    <div class="position-fixed bottom-0 start-0 p-0 w-100" style="z-index: 5">
        <div class="toast fade text-white bg-dark w-100 cookies" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="d-flex px-2">
                <div class="toast-body">
                    A weboldal használatával tudomásul veszed és elfogadod a sütik használatát. 
                </div>
                <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close" id="cookie"></button>
            </div>
        </div>
    </div>
    <script defer src="../js/allowCookies.js"></script>';} ?>
</div>
<?php session_write_close(); ?>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script defer src="../js/navbar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/anchor-js/anchor.min.js"></script>
<script type="text/javascript">
anchors.options = {
    placement: 'right',
    visible: 'hover',
    icon: '#'
};
anchors.add('anchor');
</script>
<script defer src="../js/toastInit.js"></script>
</body>
</html>