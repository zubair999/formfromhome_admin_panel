</section>
                    <!-- /.content -->
                </div>







            <!-- ./wrapper -->

        <!-- jQuery 3 -->


    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo ADMIN ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo ADMIN ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <!-- DataTables -->
    <script src="<?php echo ADMIN ?>/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo ADMIN ?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo ADMIN ?>/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="<?php echo ADMIN ?>/bower_components/moment/min/moment.min.js"></script>
    <script src="<?php echo ADMIN ?>/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- SlimScroll -->
    <!-- bootstrap datepicker -->
    <script src="<?php echo ADMIN ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?php echo ADMIN ?>/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="<?php echo ADMIN ?>/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo ADMIN ?>/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- SlimScroll -->

    <script src="<?php echo ADMIN ?>/plugins/yearpicker/yearpicker.js"></script>
    <script src="<?php echo ADMIN ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo ADMIN ?>/plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo ADMIN ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo ADMIN ?>/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo ADMIN ?>/dist/js/demo.js"></script>
    <script src="<?php echo ADMIN ?>/bower_components/moment/moment.js"></script>
    <script src="<?php echo ADMIN ?>/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="<?php echo ADMIN ?>/bower_components/fullcalendar/dist/gcal.min.js"></script>
    <script src="<?php echo ADMIN ?>/bower_components/print/printThis.js"></script>
    <script>

    $(function () {
        function init_events(ele) {
            ele.each(function () {
                var eventObject = {
                    title: $.trim($(this).text())
                }
                $(this).data('eventObject', eventObject)
                $(this).draggable({
                    zIndex: 1070,
                    revert: true,
                    revertDuration: 0
                })
            })
        }

    init_events($('#external-events div.external-event'))

    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {
            today: 'today',
            month: 'month',
            week: 'week',
            day: 'day'
        },

    events: location.origin + '/holiday/get_events',
    eventRender: function(event, element) {
        element.find('.fc-title').append("<br/>" + event.description);
        element.find('.fc-title').append("<br/>No. of Holiday:  " + event.type);
    },
    selectable: true,
    selectHelper: true,
    select: function (start, end, allDay) {
        var title = prompt("Enter Event Title");
        var desc = prompt("Enter Event Description");
        var noOfHolidays = prompt("Enter no of Holidays");
        if (title) {
            var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
            var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
            $.ajax({
                url: location.origin + '/holiday/insert_events',
                type: "POST",
                data: {
                    title: title,
                    start: start,
                    end: end,
                    description: desc,
                    noOfHolidays: noOfHolidays
                },
                success: function (data) {
                     $('#calendar').fullCalendar('removeEventSource', 'JsonResponse.ashx?technicans=' + technicians);
                     technicians = new_technicians_value;
                     $('#calendar').fullCalendar('addEventSource', 'JsonResponse.ashx?technicans=' + technicians);
                     alert("Added Successfully");
                 }
             })
         }
     },


     //  editable: true,
     //  droppable: true,
     //  drop: function (date, allDay) {

     //       // retrieve the dropped element's stored Event Object
     //       var originalEventObject = $(this).data('eventObject')

     //       // we need to copy it, so that multiple events don't have a reference to the same object
     //       var copiedEventObject = $.extend({}, originalEventObject)

     //       // assign it the date that was reported
     //       copiedEventObject.start = date
     //       copiedEventObject.allDay = allDay
     //       copiedEventObject.backgroundColor = $(this).css('background-color')
     //       copiedEventObject.borderColor = $(this).css('border-color')


     //       $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

     //       // is the "remove after drop" checkbox checked?
     //       if ($('#drop-remove').is(':checked')) {
     //            // if so, remove the element from the "Draggable Events" list
     //            $(this).remove()
     //       }

     //  }
})


var currColor = '#3c8dbc'
var colorChooser = $('#color-chooser-btn')
$('#color-chooser > li > a').click(function (e) {
     e.preventDefault()

     currColor = $(this).css('color')

     $('#add-new-event').css({
          'background-color': currColor,
          'border-color': currColor
     })
})
$('#add-new-event').click(function (e) {
     e.preventDefault()

     var val = $('#new-event').val()
     if (val.length == 0) {
          return
     }


     var event = $('<div />')
     event.css({
          'background-color': currColor,
          'border-color': currColor,
          'color': '#fff'
     }).addClass('external-event')
     event.html(val)
     $('#external-events').prepend(event)


     init_events(event)


     $('#new-event').val('')
})
})




</script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>


    <script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
        {
            ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
        },
        function (start, end) {
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
        );

        //Date picker
        // $('#datepicker1').datepicker({
        // autoclose: true
        // });
        //
        // $('#datepicker2').datepicker({
        // autoclose: true
        // });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
        });

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
        showInputs: false
        });
    });
    </script>
    <script>
    $(function () {
        $('#example1').DataTable({
            "order": [[ 0, "desc" ]]
        })




        $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
        });
    });

    $('#last-date').datepicker({
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
    });

    $('#post-date').datepicker({
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
    });

    $('#stuDob').datepicker({
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
      yearRange: "1980:2050"
    });

    </script>



<!-- ALL CUSTOM JS FILE -->
  <<script src="https://cdn.tiny.cloud/1/ldufmj1cahhmkgx4gsyfa916yabujc3k0fqhybl17q7em7vg/tinymce/5/tinymce.min.js"></script>
    <script src="<?php echo ADMIN ?>dist/js/report.js"></script>
    <script src="<?php echo ADMIN ?>dist/js/notification.js"></script>
    <script src="<?php echo ADMIN ?>dist/js/charts.js"></script>
    <script src="<?php echo ADMIN ?>dist/js/clipboard.min.js"></script>
    <script src="<?php echo ADMIN ?>dist/js/custom.js"></script>
    <script src="<?php echo ADMIN ?>dist/js/dataTable.js"></script>
    <script src="<?php echo ADMIN ?>dist/js/new_custom.js"></script>
<!-- custom js -->

        </body>
    </html>
