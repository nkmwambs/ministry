<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denomination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css"/>
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</head>
<body>
    <div class = "fluid-container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Denominations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../ministers/list.html">Ministers</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" href="../churches/list.html">Churches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../events/list.html">Events</a>
                  </li>
                
              </ul>
            </div>
          </nav>
          <div class = "main">

            <div class = "row">
                <div class = "col-xs-12">
                    <div class = "page-title"><i class = 'fa fa-book'></i> List Denominations</div>
                </div>
            </div>

            <div class = "row">
                <div class = "col-xs-12 btn-container">
                    <a href = "add.html" class = 'btn btn-primary'>Add Denomination</a>
                </div>
            </div>

            <div class = "row">
                <div class = "col-xs-12">
                    <table class="table table-striped datatable">
                        <thead>
                          <tr>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Registration Date</th>
                            <th>Email</th>
                            <th>Phome</th>
                            <th>Head Office</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                                <span class = 'action-icons'><a href="view.html"><i class = 'fa fa-search'></i></a></i></span>
                                <span class = 'action-icons'><a href="edit.html"><i class = 'fa fa-pencil'></i></a></span>
                                <span class = 'action-icons'><i class = 'fa fa-trash'></i></span>
                            </td>
                            <td>Anglican Church Of Kenya</td>
                            <td>12/10/1923</td>
                            <td>ack-kenya@gmail.com</td>
                            <td>+245711234567</td>
                            <td>Nairobi</td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>
          </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

<script>
    $('.datatable').DataTable();
</script>
</html>