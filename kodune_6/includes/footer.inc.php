<?php 

$fullTimeNow = date("d.m.Y H:i:s");
//<p>Lehe avamise hetkel oli: <strong>31.01.2020 11:32:07</strong></p>
$timeHTML  = "\n <p>Lehe avamise hetkel oli: <strong>" . $fullTimeNow . "</strong></p> \n";

?>

<footer class="footer mt-auto py-3">
  <div class="container text-center">
    <hr>
    <span class="text-muted">See koduleht on valminud õppetöö raames. <?php echo $timeHTML; ?>
    </span>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
  integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
  integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
  integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="js/lightbox-plus-jquery.min.js"></script>

<!-- Lightbox options -->
<script>
lightbox.option({
  'resizeDuration': 200,
  'wrapAround': true,
  'fadeDuration': 200
})
</script>

</body>

</html>