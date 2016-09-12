<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Wersja</b> 2.0
    </div>
    <strong>Oprogramowanie stworzył:<a href="#">Mariusz Morawiec</a>.</strong> tel 79 11614
</footer>

<!-- Control Sidebar -->
<?php include 'bok.php'; ?>
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="./plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="./plugins/jQueryUI/jquery-ui.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="./bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="./plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>

<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="./plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="./plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="./plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="./plugins/timepicker/bootstrap-timepicker.min.js"></script>


<!--Satatable-->
<script src="./plugins/datatables/jquery.dataTables.js"></script>
<script src="./plugins/datatables/dataTables.bootstrap.js"></script>

<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
        $('#reservation').daterangepicker();
        //Date range picker with time picker

        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });
        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });
        $(".timepicker2").timepicker({
            showInputs: false
        });
        $('#nadgodziny-od').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "locale": {
                "format": "YYYY-MM-DD H:mm",
                "separator": " - ",
                "applyLabel": "Zastosuj",
                "cancelLabel": "Anuluj",
                "fromLabel": "Od",
                "toLabel": "Do",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Nie",
                    "Po",
                    "Wt",
                    "Śr",
                    "Czw",
                    "Pt",
                    "Sob"
                ],
                "monthNames": [
                    "Styczeń",
                    "Luty",
                    "Marzec",
                    "Kwiecień",
                    "Maj",
                    "Czerwiec",
                    "Lipiec",
                    "Sierpień",
                    "Wrzesień",
                    "Październik",
                    "Listopad",
                    "Grudzień"
                ],
                "firstDay": 1
            },
            "startDate": new Date()

        },

            function(start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD h:m') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });

        $('#nadgodziny-do').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "locale": {
                    "format": "YYYY-MM-DD HH:mm",
                    "separator": " - ",
                    "applyLabel": "Zastosuj",
                    "cancelLabel": "Anuluj",
                    "fromLabel": "Od",
                    "toLabel": "Do",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Nie",
                        "Po",
                        "Wt",
                        "Śr",
                        "Czw",
                        "Pt",
                        "Sob"
                    ],
                    "monthNames": [
                        "Styczeń",
                        "Luty",
                        "Marzec",
                        "Kwiecień",
                        "Maj",
                        "Czerwiec",
                        "Lipiec",
                        "Sierpień",
                        "Wrzesień",
                        "Październik",
                        "Listopad",
                        "Grudzień"
                    ],
                    "firstDay": 1
                },
                "startDate": new Date()

            },

            function(start, end, label) {
                console.log("New date range selected: ' + start.format('YYYY-MM-DD h:m') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
            });


    });
</script>

</body>
</html>
