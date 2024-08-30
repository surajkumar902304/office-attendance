  <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">employees Record Management System</div>
                            <div>
                         
                        </div>
                    </div>
                </footer>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="<?php echo base_url('assets/js/scripts.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('assets/demo/chart-area-demo.js') ?>"></script>
    <script src="<?php echo base_url('assets/demo/chart-bar-demo.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('assets/js/datatables-simple-demo.js') ?>"></script>
    <script>
        // Show a simple alert if there is a message
        <?php if (isset($message)): ?>
            alert('<?php echo $message; ?>');
        <?php endif; ?>
    </script>
</body>

</html>