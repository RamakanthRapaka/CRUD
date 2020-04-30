<html lang="en">
    <head>
        <title>
            Student Registration
        </title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"></link>
        <script src="https://code.jquery.com/jquery-1.12.4.js">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js">
        </script>
    </head>
    <body>
        <br/>
        <div class="container">
            <div class="panel panel-primary" style="width:750px;margin:0px auto">


                <div class="panel-heading">Student Registration</div>
                <div class="panel-body">


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
            </div>
        </div>
        <script>
            $(document).ready(function () {
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
                        return false;
                    }
                });
            });
        </script>	
    </body>
</html>