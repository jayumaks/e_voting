
<?php include ('head.php');?>

<body>

    <div id="wrapper">

      
              <?php include ('view_banner.php');?>
       
       <div class="menue-select">
  <select onchange="page(this.value)">
    <option disabled selected>Select Candidate Group</option>
    <option value="candidates/pres.php">President</option>
    <option value="candidates/vp.php">Vice President</option>
    <option value="candidates/tr.php">Treasurer</option>
    <option value="candidates/sg.php">Secretary General</option>
    <option value="candidates/ta.php">Welfare</option>
    <option value="candidates/pb.php">PRO</option>
  </select>
</div>

        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php    
        include ('footer.php');
        ?>

    <script>
    function page (src){
        window.location=src;
    }
    </script>

</body>

</html>

