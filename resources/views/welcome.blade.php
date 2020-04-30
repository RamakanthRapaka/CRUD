<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
        <style>
            #pagination a {
                display:inline-block;
                margin-right:5px;

            }


        </style>
    </head>
    <body>
        <table id="employee" class="table table-bordered table table-hover" cellspacing="0" width="100%">
            <colgroup><col><col><col></colgroup>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Pin Code</th>
                    <th>address</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="emp_body">
            </tbody>
        </table>
        <div id="pager">
            <ul id="pagination" class="pagination-sm"></ul>
        </div>


        <script>
            var $pagination = $('#pagination'),
                    totalRecords = 0,
                    records = [],
                    displayRecords = [],
                    recPerPage = 2,
                    page = 1,
                    totalPages = 0;
            $.ajax({
                url: "http://school/api/v1/fetchall",
                async: true,
                dataType: 'json',
                type: 'POST',
                success: function (data) {
                    records = data;
                    console.log(records);
                    totalRecords = records.count;
                    totalPages = Math.ceil(totalRecords / recPerPage);
                    apply_pagination(totalPages);
                }
            });

            function generate_table() {
                var tr;
                $('#emp_body').html('');
                for (var i = 0; i < displayRecords.length; i++) {
                    tr = $('<tr/>');
                    tr.append("<td>" + displayRecords[i].id + "</td>");
                    tr.append("<td>" + displayRecords[i].name + "</td>");
                    tr.append("<td>" + displayRecords[i].class + "</td>");
                    tr.append("<td>" + displayRecords[i].city + "</td>");
                    tr.append("<td>" + displayRecords[i].state + "</td>");
                    tr.append("<td>" + displayRecords[i].pincode + "</td>");
                    tr.append("<td>" + displayRecords[i].address + "</td>");
                    tr.append("<td>" + displayRecords[i].created_at + "</td>");
                    tr.append("<td>" + displayRecords[i].updated_at + "</td>");
                    tr.append("<td id=" + displayRecords[i].id + "><button type='button' id='edit' name='edit' class='btn btn-primary'>Edit</button> <button type='button' id='delete' name='delete' class='btn btn-danger'>Delete</button></td>");
                    $('#emp_body').append(tr);
                }
            }

            function apply_pagination(totalPages) {
                $pagination.twbsPagination({
                    totalPages: totalPages,
                    visiblePages: 6,
                    onPageClick: function (event, page) {
                        displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                        endRec = (displayRecordsIndex) + recPerPage;

                        displayRecords = records.data.slice(displayRecordsIndex, endRec);
                        generate_table();
                    }
                });
            }
        </script>

    </body>
</html>