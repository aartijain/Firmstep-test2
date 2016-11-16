
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Firmstep Queue App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <script src="/js/jquery-1.11.0.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script>
      $(function($){
        $('#form').validator().on('submit', function (e) {
            
        })
        $('button[type="button"]').click(function(){
            console.log(this.value);
            buttonValue = this.value;
            $('input[name="type_id"]').val(this.value);
            
            switch(buttonValue) {
                case '1' :
                    $('input[name=organisation_name]').parent().hide();
                    
                    $('input[name=first_name]').parent().show();
                    $('input[name=last_name]').parent().show();
                    $('input[name=title]').parent().show();

                    break;
                case '2':
                    $('input[name=first_name]').parent().hide();
                    $('input[name=last_name]').parent().hide();
                    $('input[name=title]').parent().hide();
                    
                    $('input[name=organisation_name]').parent().show();
                    break;
                case '3':
                    $('input[name=first_name]').parent().hide();
                    $('input[name=last_name]').parent().hide();
                    $('input[name=title]').parent().hide();
                    $('input[name=organisation_name]').parent().hide();
                    break;
                default:
                    alert('test');
                    break;
            }
        });
    });
        
  </script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <h2>Queue App</h2>
    </div>
    
  </div>
</nav>
  
<div class="container">
  <h3>Queue</h3>
  <ul class="nav nav-tabs">
      <li class=""><a data-toggle="tab" href="#addCustomer">Add Customer</a></li>
      <li class="active"><a data-toggle="tab" href="#listCustomer">Customer List</a></li>
    </ul>
    
  <div class="tab-content">
    <div id="addCustomer" class="tab-pane fade ">
        <h2> New Customer </h2>
        <form method="post" action="post.php" data-toggle="validator">
            <div class="form-group">
              <label for="services">Services:</label>
              <?php foreach($data['serviceList'] as $service): ?>
                <div class="radio">
                    <label><input type="radio" name="service_id" required value="<?= $service->id; ?>"><?= $service->name; ?></label>
                </div>
              <?php endforeach; ?>
            </div>
            
             <div class="btn-group">
                 <?php foreach($data['typeList'] as $type): ?>
                 <button type="button" class="btn btn-primary"  value="<?= $type->id;?>" ><?= $type->name; ?></button>
                <?php endforeach; ?>
             </div>
            <div class="form-group">
              <label for="">Title:</label>
              <input type="" name="title" class="form-control" id="title">
            </div>
            <div class="form-group">
              <label for="">Firstname:</label>
              <input type="" class="form-control" name="first_name">
            </div>
             <div class="form-group">
              <label for="">LastName:</label>
              <input type="" class="form-control" name="last_name">
            </div>
             <div class="form-group">
              <label for="">Organisation Name:</label>
              <input type="" class="form-control" name="organisation_name">
            </div>
            <input type="hidden" name="type_id" value="">
            <input type="submit" value="submit" name="submit" class="btn btn-primary">
          </form>
    </div>
    
    <div id="listCustomer" class="tab-pane fade in active">
    <h3>Queue</h3>            
  <table class="table table-striped">
    <thead>
        <tr>List of the customers being queued. </tr>
      <tr>
        <th>Type</th>
        <th>Name</th>
        <th>Service</th>
        <th>Queued at</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($data['customerList'] as $row) :?>
        <tr>
            <td><?= $row['type_name']; ?></td>
            <td><?php if ($row['type_id'] == 1): ?>
                <?php echo $row['first_name'].' '.$row['last_name']; ?>
                <?php elseif ($row['type_id'] == 2): ?>
                    <?= $row['organisation_name']; ?>
                <?php else: ?>
                    Anonymous
                <?php endif; ?>
            </td>
            <td><?= $row['service_name']; ?></td>
            <td><?= $row['date_arrived']; ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
    </div>
  </div>
</div>
</body>
</html>

