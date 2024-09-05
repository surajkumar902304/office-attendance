<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet'
        media='print' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <style>
        .fc-event {
            cursor: pointer;
        }

        .event-icons {
            float: right;
            margin-left: 5px;
        }

        #calendar .fc-row {
            height: auto !important;
        }

        #calendar .fc-scroller {
            height: auto !important;
        }
    </style>
    
</head>

<body class="sb-nav-fixed">
    <?php include APPPATH . 'views/include/header.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include APPPATH . 'views/include/sidebar.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <h1>EVENT MANAGEMENT</h1>
                    <div id="calendar"></div>
                </div>
            </main>
            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>

    <!-- Modal for adding/editing events -->
    <div id="eventModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="eventId">
                        <div class="form-group">
                            <label for="eventTitle">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="eventDate">Event Date</label>
                            <input type="date" class="form-control" id="eventDate" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEvent">Save Event</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                eventLimit: true,
                events: <?php echo json_encode($events); ?>,
                dayClick: function (date) {
                    openEventModal(null, date);
                },
                eventClick: function (event) {
                    openEventModal(event);
                },
                eventRender: function (event, element) {
                    element.find('.fc-content').append(
                        "<span class='event-icons'>" +
                        "<i class='fa fa-edit' onclick='editEvent(" + event.id + ")'></i> " +
                        "<i class='fa fa-trash' onclick='deleteEvent(" + event.id + ")'></i>" +
                        "</span>"
                    );
                }
            });

            // Close button functionality
            $('#closeModal, .close').click(function () {
                $('#eventModal').modal('hide');
            });

            // Save Event button functionality
            $('#saveEvent').click(function () {
                var eventData = {
                    id: $('#eventId').val(),
                    title: $('#eventTitle').val(),
                    date: $('#eventDate').val()  // Changed 'start' to 'date' to match your controller
                };

                var url = eventData.id ?
                    '<?php echo base_url('events/edit/'); ?>' + eventData.id :
                    '<?php echo base_url('events/add'); ?>';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: eventData,
                    success: function (response) {
                        $('#eventModal').modal('hide');
                        $('#calendar').fullCalendar('refetchEvents');
                    },
                    error: function (xhr, status, error) {
                        console.error("Error saving event:", error);
                        alert("There was an error saving the event. Please try again.");
                    }
                });
            });

            // Prevent form submission on enter key
            $('#eventForm').on('submit', function (e) {
                e.preventDefault();
                $('#saveEvent').click();
            });
        });

        function openEventModal(event, date) {
            if (event) {
                $('#eventId').val(event.id);
                $('#eventTitle').val(event.title);
                $('#eventDate').val(moment(event.start).format('YYYY-MM-DD'));
            } else {
                $('#eventId').val('');
                $('#eventTitle').val('');
                $('#eventDate').val(date.format('YYYY-MM-DD'));
            }
            $('#eventModal').modal('show');
        }

        function editEvent(eventId) {
            var event = $('#calendar').fullCalendar('clientEvents', eventId)[0];
            openEventModal(event);
        }

        function deleteEvent(eventId, event) {
            if (event) {
                event.stopPropagation();
            }
            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: '<?php echo base_url('events/delete/'); ?>' + eventId,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#calendar').fullCalendar('removeEvents', eventId);
                        } else {
                            alert("There was an error deleting the event: " + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error deleting event:", error);
                        alert("There was an error deleting the event. Please try again.");
                    }
                });
            }
        }
    </script>
</body>

</html>