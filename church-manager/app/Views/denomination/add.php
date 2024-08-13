<div class = "main">
            <div class = "row">
                <div class = "col-xs-12">
                    <div class = "page-title"><i class = 'fa fa-plus-circle'></i> Add Denomination</div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 btn-container">
                    <a href="list.html" class = "btn btn-info">Back</a>
                </div>
            </div>

            <div class = "row">
                <div class="col-xs-12">
                    <form>
                        <div class="form-group">
                          <label class="control-label col-xs-4" for="denomination_name">Name</label>
                          <div class="col-xs-8">
                            <input type="text" class="form-control" name = "denomination_name" id="denomination_name" placeholder="Enter Name">
                          </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="code">Code</label>
                            <div class="col-xs-8">
                              <input type="text" class="form-control" name = "code" id="code" placeholder="Enter Code">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="registration_date">Registration Date</label>
                            <div class="col-xs-8">
                              <input type="text" onkeydown="return false;"  class="form-control datepicker" name = "registration_date" id="registration_date" placeholder="Enter Registration Date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="head_office">Head Office</label>
                            <div class="col-xs-8">
                              <input type="text" class="form-control" name = "head_office" id="head_office" placeholder="Enter Head Office">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="email">Email</label>
                            <div class="col-xs-8">
                              <input type="email" class="form-control" name = "email" id="email" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="phone">Phone</label>
                            <div class="col-xs-8">
                              <input type="text" class="form-control" name = "phone" id="phone" placeholder="Enter Phone">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="submit" class="btn btn-primary">Save and New</button>
                        <button type="submit" class="btn btn-primary">Reset</button>
                      </form>
                </div>
            </div>
            
          </div>