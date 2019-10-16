</div>
<!--**********************************
        Content body end
    ***********************************-->



</div>
<!--**********************************
        Main wrapper end
    ***********************************-->

<!--**********************************
        Scripts
    ***********************************-->
    
    <!-- <script src="plugins/common/common.min.js"></script> -->
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>

     <!--  flot-chart js -->
     
     <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 4 && strpos($_SERVER['PHP_SELF'], 'index.php')) : ?>
	<script src="./plugins/flot/js/jquery.flot.min.js"></script>
    <script src="./plugins/flot/js/jquery.flot.pie.js"></script>
    <script src="./plugins/flot/js/jquery.flot.resize.js"></script>
    <script src="./plugins/flot/js/jquery.flot.spline.js"></script>
    <script src="./plugins/flot/js/jquery.flot.init.js"></script>
    <?php endif ?>
    <script src="js/org_forms.js"></script>
    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    

</body>

</html>