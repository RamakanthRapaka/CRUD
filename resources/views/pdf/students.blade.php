<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            .banner_h {display: block; margin:0; padding: 0; width: 100%;}
            .banner_h img {width:100%}

            .divTable{
                display: table;
                font-size: 10px;
                width: 100%;
            }
            .divTableRow {
                display: table-row;
            }
            .divTableHeading {
                background-color: #EEE;
                display: table-header-group;
            }
            .divTableCell, .divTableHead {
                border: 1px solid #999999;
                display: table-cell;
                padding: 3px 10px;
            }
            .divTableHeading {
                background-color: #EEE;
                display: table-header-group;
                font-weight: bold;
            }
            .divTableFoot {
                background-color: #EEE;
                display: table-footer-group;
                font-weight: bold;
            }
            .divTableBody {
                display: table-row-group;
            }
        </style>
    </head>
    <body>  
        <div class="tex-center col-sm-12 banner_h">
        </div>
        @if (!empty($students))
    <center><h3>Students</h3></center>
    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">
                <div class="divTableCell">ID</div>
                <div class="divTableCell">Name</div>
                <div class="divTableCell">Class</div>
                <div class="divTableCell">City</div>
                <div class="divTableCell">State</div>
                <div class="divTableCell">Pin Code</div>
                <div class="divTableCell">Address</div>
                <div class="divTableCell">Created</div>
                <div class="divTableCell">Updated</div>
            </div>
            @foreach($students as $student)
            <div class="divTableRow">
                <div class="divTableCell">{{$student['id'] }}</div>
                <div class="divTableCell">{{$student['name']}}</div>
                <div class="divTableCell">{{$student['class']}}</div>
                <div class="divTableCell">{{$student['city']}}</div>
                <div class="divTableCell">{{$student['state']}}</div>
                <div class="divTableCell">{{$student['pincode']}}</div>
                <div class="divTableCell">{{$student['address']}}</div>
                <div class="divTableCell">{{$student['created_at']}}</div>
                <div class="divTableCell">{{$student['updated_at']}}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>    
</html>
