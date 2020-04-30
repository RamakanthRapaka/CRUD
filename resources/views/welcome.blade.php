<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Student</h4>
                    </div>
                    <div class="modal-body">
                        <form data-toggle="validator" role="form" id="addPersonForm" name="addPersonForm" method="POST">


                            <div class="form-group">
                                <label class="control-label" for="name">Name</label>
                                <input class="form-control" data-error="Please enter name field." id="name" name="name" placeholder="Name"  type="text" required />
                                <div class="help-block with-errors"></div>
                            </div>


                            <div class="form-group">
                                <label for="class" class="control-label">Class</label>
                                <input type="number" class="form-control" id="class" name="class" placeholder="Class" required>
                                <div class="help-block with-errors"></div>
                            </div>


                            <div class="form-group">
                                <label for="city" class="control-label">City</label>
                                <div class="form-group">
                                    <input type="text" data-minlength="4" class="form-control" id="city" name="city" data-error="must enter minimum of 4 characters" placeholder="City" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label" for="state">State</label>
                                <input type="text" data-minlength="4" class="form-control" id="state" name="state" data-error="must enter minimum of 4 characters" placeholder="State" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="state">PinCode</label>
                                <input type="number" data-minlength="6" class="form-control" id="pincode" name="pincode" data-error="must enter minimum of 6 characters" placeholder="PinCode" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="address">Address</label>
                                <textarea class="form-control" data-error="Please enter Address field." id="address" name="address" placeholder="Address" required=""></textarea>
                                <div class="help-block with-errors"></div>
                            </div>	

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <script>
            $(document).ready(function () {
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
                $(document).on("click", "#edit", function () {
                    $('#myModal').modal('show');
                    var perform = this.id;
                    var row_id = $(this).closest('td').attr('id');
                    console.log(perform);
                    console.log(row_id);
                });
            });
        </script>

    </body>
</html>