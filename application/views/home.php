<!DOCTYPE html>

<html lang="en">
        <title>GBSP | Dashboard</title>
<head>
        <?php $this->load->view('hfs/html_header'); ?>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
           <?php $this->load->view('hfs/header') ?>
            <div class="clearfix"> </div>
            <div class="page-container">
                
               <?php // $this->load->view('hfs/side_menu') ?> 
                <div class="page-content-wrapper">
                    <div class="page-content">
                    <!--     <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="index.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Form Stuff</span>
                                </li>
                            </ul>
                            
                        </div> -->
                        <!-- <h1 class="page-title"> Bootstrap Form Controls
                            <small>bootstrap inputs, input groups, custom checkboxes and radio controls and more</small>
                        </h1> -->
                       <div class="row">
                           <div class="col-md-3"></div>
                             <div class="col-md-6 ">
                                
                                <div class="portlet light bordered" style="padding-bottom: 29px;">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo" align="center">
                                            <!-- <i class="icon-settings font-red-sunglo"></i> -->
                                            <span class="caption-subject bold uppercase"> Search Account Holder Information</span>
                                        </div>
                                        
                                    </div>
                                    <div class="portlet-body form">
                                        <?php echo form_open('',array('id'=>'find_info')) ?>
                                           <div class="form-body">
                                             <div class="col-md-6">
                                              <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control " placeholder="Enter Account Number" name="account_number">
                                                </div>
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <button type="button" id="btn1" class="btn blue">Submit</button>
                                                </div>
                                             </div>  
                                             <div id="err111"></div>  
                                           </div>
                                            <!-- <div class="form-actions" align="center">
                                                <button type="submit" class="btn blue">Submit</button>
                                                <button type="button" class="btn default">Cancel</button>
                                            </div> -->
                                        <?php echo form_close() ?>
                                    </div>
                                </div>
                              
                            </div>
                           <div class="col-md-3"></div>
                       </div>

                        <div class="row">
                          
                             <div class="col-md-12 ">
                                <div class="portlet box blue ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i> User Information </div>
                                    </div>
                                    <div class="portlet-body form">
                                      <?php echo form_open('',array('id'=>'update_data')) ?>
                                            <div class="form-body">
                                               <div class="row">
                                                   <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Account Number</label>
                                                        <div class="col-md-6">
                                                        <input type="text" class="form-control input-sm" placeholder="Account Number" name="account_number" id="account_number" readonly="true"> </div>
                                                    </div> 
                                                   </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Name</label>
                                                        <div class="col-md-6">
                                                        <input type="text" id="name" class="form-control input-sm" placeholder="Account Holder Name" name="holder_name" readonly="true"> </div>
                                                    </div> 
                                                </div>
                                               </div>
                                            </div>

                                            <div class="form-body">
                                               <div class="row">
                                                   <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Current Balance</label>
                                                        <div class="col-md-6">
                                                        <input type="text" class="form-control input-sm" placeholder="Current Balance" name="current_balance" id="current_balance" readonly="true"> </div>
                                                    </div> 
                                                   </div>
                                                <div class="col-md-6">
                                                    <label class="mt-radio mt-radio-outline">
                                                                <input type="radio" name="type"  value="credit"> Credit
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio mt-radio-outline">
                                                                <input type="radio" name="type"  value="debit" >Debit
                                                                <span></span>
                                                            </label>
                                                </div>

                                               </div>                                               
                                            </div>

                                              <div class="form-body">
                                               <div class="row">
                                                   <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Enter Amount</label>
                                                        <div class="col-md-6">
                                                        <input type="text" class="form-control input-sm" placeholder="Enter  Amount" name="deposite_amount" id="deposite_amount"> </div>
                                                    </div> 
                                                </div>
                                                   <div class="col-md-6">
                                                    <!-- <button type="button" class="btn default">Cancel</button> -->
                                                    <button type="button" id="btn2" class="btn red">Submit</button>
                                                   </div>
                                                
                                                    
                                                </div>
                                               </div>                                               
                                            </div>


                                            
                                        </form>
                                    </div>
                                </div>
                              
                            </div>
                         
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        

        <?php $this->load->view('hfs/footer') ?>

<script type="text/javascript">
    $(document).ready(function() {
            
        $('#btn1').click(function(){

            $.ajax({
                url : "<?php echo base_url('index.php/accounts/get_details') ?>",
                data : $('#find_info').serialize(),
                type : "POST",

                success:function(resp){
                    var returnData = JSON.parse(resp);
                    console.log(returnData);
                    if(returnData.status==true){
                      $('#account_number').val(returnData.account_number);
                      $('#name').val(returnData.name);
                      $('#current_balance').val(returnData.new_balance);
                      $('#err111').html('');
                    }else{
                        $('#err111').html(returnData.message);
                    }
                },
                error:function(err){
                  console.log(err);
                }
            })
        });

        $('#btn2').click(function(){
          $.ajax({
            url : "<?php echo base_url('index.php/accounts/put_data') ?>",
            data : $('#update_data').serialize(),
            type : "POST",

            success:function(resp){
              console.log(resp);
            }
          })
        })
    })
</script>

</body>

</html>