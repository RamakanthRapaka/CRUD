<html>
<head>
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #pagination a {
            display: inline-block;
            margin-right: 5px;
        }

        .action-td {
            display: flex;
            align-items: center;
            justify-content: space-between;
            vertical-align: middle;
            /*border: none;*/
        }


    </style>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-11">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-7">
                            <input class="form-control" id="search" name="search" placeholder="Search" type="text"/>
                        </div>
                        <div class="col-sm-5">
                            <button type="button" id="addnew" name="addnew" class="btn btn-primary"><i
                                    class="fa fa-user-plus"></i> Add New
                            </button>
                            <button class="btn" id="pdf" name="pdf"><i class="fa fa-download"></i> PDF</button>
                            <button class="btn" id="xlsx" name="xlsx"><i class="fa fa-download"></i> XLSX</button>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="employee" class="table table-bordered table-hover" cellspacing="0" width="100%">
                        <colgroup>
                            <col>
                            <col>
                            <col>
                        </colgroup>
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
                </div>
                <div class="card-footer">
                    <div id="pager">
                        <ul id="pagination" class="pagination-sm"></ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Edit Student</h4>
                </div>
                <div class="modal-body">
                    <form data-toggle="validator" role="form" id="addPersonForm" name="addPersonForm" method="POST">


                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input type="hidden" id="id" name="id" value=""/>
                            <input class="form-control" data-error="Please enter name field." id="name" name="name"
                                   placeholder="Name" type="text" required/>
                            <div class="help-block with-errors"></div>
                        </div>


                        <div class="form-group">
                            <label for="class" class="control-label">Class</label>
                            <input type="number" class="form-control" id="class" name="class" placeholder="Class"
                                   required>
                            <div class="help-block with-errors"></div>
                        </div>


                        <div class="form-group">
                            <label for="city" class="control-label">City</label>
                            <div class="form-group">
                                <input type="text" data-minlength="4" class="form-control" id="city" name="city"
                                       data-error="must enter minimum of 4 characters" placeholder="City" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="state">State</label>
                            <input type="text" data-minlength="4" class="form-control" id="state" name="state"
                                   data-error="must enter minimum of 4 characters" placeholder="State" required>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="state">PinCode</label>
                            <input type="number" data-minlength="6" class="form-control" id="pincode" name="pincode"
                                   data-error="must enter minimum of 6 characters" placeholder="PinCode" required>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="address">Address</label>
                            <textarea class="form-control" data-error="Please enter Address field." id="address"
                                      name="address" placeholder="Address" required=""></textarea>
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

            $("#search").keyup(function () {
                if ($("#search").length > 2) {
                    // $('#emp_body').html('Searching....');
                    let value = $(this).val();

                    $("#emp_body tr").each(function (index) {
                        if (index !== 0) {

                            $row = $(this);

                            var id = $row.find("td.name").text();

                            if (id.indexOf(value) !== 0) {
                                $row.hide();
                            } else {
                                $row.show();
                            }
                        }
                    });

                } else {
                    Pagination();
                }
            });

            function Pagination() {
                records = [];
                $.ajax({
                    url: "http://school/api/v1/fetchall",
                    async: true,
                    dataType: 'json',
                    type: 'POST',
                    data: {name: $('input[name="search"]').val()},
                    success: function (data) {
                        records.push(data);

                        console.log(records[0]);
                        totalRecords = records[0].count;
                        totalPages = Math.ceil(totalRecords / recPerPage);

                        apply_pagination(totalPages);
                        
                        generate_table();
                    }
                });
            }

            Pagination();

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
                    tr.append("<td class='action-td' id=" + displayRecords[i].id + ">" +
                        "<div>" +
                        "<button title='Edit' type='button' id='edit' name='edit' class='btn btn-primary mb-1'> " +
                        "<i class='fa fa-pencil'></i></button> " +
                        "<button title='Delete' type='button' id='delete' name='delete' class='btn btn-danger'> " +
                        "<i class='fa fa-trash'></i></button></td>" +
                        "</div>"
                    );
                    $('#emp_body').append(tr);
                }
            }

            function apply_pagination(totalPages) {
                displayRecords = records[0].data;
                generate_table();
               // if(isNaN(totalPages)) {
               //     totalPages = 1
               // }

                $pagination.twbsPagination({
                    totalPages: totalPages,
                    visiblePages: 6,
                    onPageClick: function (event, page) {
                        displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
                        endRec = (displayRecordsIndex) + recPerPage;

                        displayRecords = records[0].data.slice(displayRecordsIndex, endRec);
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
                $.ajax({
                    url: 'http://school/api/v1/findbyid',
                    type: 'POST',
                    data: {id: row_id},
                    async: true,
                    success: function (data) {
                        console.log(data);
                        $('input[name="id"]').val(data.data.id);
                        $('input[name="name"]').val(data.data.name);
                        $('input[name="class"]').val(data.data.class);
                        $('input[name="city"]').val(data.data.city);
                        $('input[name="state"]').val(data.data.state);
                        $('input[name="pincode"]').val(data.data.pincode);
                        $("textarea#address").val(data.data.address);
                    }
                });
            });

            $(document).on("click", "#addnew", function () {
                $('#myModal').modal('show');
            });

            $(document).on("click", "#pdf", function () {

                var data = new FormData();
                data.append('download', 'pdf');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'http://school/api/v1/fetchall', true);
                xhr.responseType = 'arraybuffer';
                xhr.onload = function () {
                    if (this.status === 200) {
                        var filename = "";
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1])
                                filename = matches[1].replace(/['"]/g, '');
                        }
                        var type = xhr.getResponseHeader('Content-Type');
                        var blob = new Blob([this.response], {type: type});
                        if (typeof window.navigator.msSaveBlob !== 'undefined') {
                            // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                            window.navigator.msSaveBlob(blob, filename);
                        } else {
                            var URL = window.URL || window.webkitURL;
                            var downloadUrl = URL.createObjectURL(blob);

                            if (filename) {
                                // use HTML5 a[download] attribute to specify filename
                                var a = document.createElement("a");
                                // safari doesn't support this yet
                                if (typeof a.download === 'undefined') {
                                    window.location = downloadUrl;
                                } else {
                                    a.href = downloadUrl;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.click();
                                }
                            } else {
                                window.location = downloadUrl;
                            }

                            setTimeout(function () {
                                URL.revokeObjectURL(downloadUrl);
                            }, 100); // cleanup
                        }
                    }
                };
                xhr.send(data);
            });

            $(document).on("click", "#xlsx", function () {
                var data = new FormData();
                data.append('download', 'xlsx');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'http://school/api/v1/fetchall', true);
                xhr.responseType = 'arraybuffer';
                xhr.onload = function () {
                    if (this.status === 200) {
                        var filename = "";
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1])
                                filename = matches[1].replace(/['"]/g, '');
                        }
                        var type = xhr.getResponseHeader('Content-Type');
                        var blob = new Blob([this.response], {type: type});
                        if (typeof window.navigator.msSaveBlob !== 'undefined') {
                            // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                            window.navigator.msSaveBlob(blob, filename);
                        } else {
                            var URL = window.URL || window.webkitURL;
                            var downloadUrl = URL.createObjectURL(blob);

                            if (filename) {
                                // use HTML5 a[download] attribute to specify filename
                                var a = document.createElement("a");
                                // safari doesn't support this yet
                                if (typeof a.download === 'undefined') {
                                    window.location = downloadUrl;
                                } else {
                                    a.href = downloadUrl;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.click();
                                }
                            } else {
                                window.location = downloadUrl;
                            }

                            setTimeout(function () {
                                URL.revokeObjectURL(downloadUrl);
                            }, 100); // cleanup
                        }
                    }
                };
                xhr.send(data);
            });

            $(document).on("click", "#delete", function () {
                var perform = this.id;
                var row_id = $(this).closest('td').attr('id');
                console.log(perform);
                console.log(row_id);
                $(this).closest("tr").remove();
                $.ajax({
                    url: 'http://school/api/v1/delete',
                    type: 'POST',
                    data: {id: row_id},
                    async: true,
                    success: function (data) {
                        console.log(data);
                        Pagination();
                    }
                });
            });

            $('#addPersonForm').validator().on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                    console.log('Invalid');
                } else {
                    var formData = new FormData($(this)[0]);
                    $.ajax({
                        url: 'http://school/api/v1/saveorupdatestudent',
                        type: 'POST',
                        data: formData,
                        async: true,
                        success: function (data) {
                            $('#res').html(data);
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    $(this)[0].reset();
                    $('#myModal').modal('hide');
                    Pagination();
                    return false;
                }
            });
        }
    );
</script>

</body>
</html>
