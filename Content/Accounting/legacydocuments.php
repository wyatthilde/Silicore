<?php

/* * *****************************************************************************************************************************************
 * File Name: LegacyDocuments.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/25/2019|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP



//========================================================================================== END PHP
?>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.css" type="text/css" media="screen" />

<div class="container-fluid">
  
  <div class="card" id="ap-content-card">
    <div class="card-body">
      <h3 style='cursor: pointer'>
        <div id='ap-header' class='content-header vprop-blue-text'>
          Accounts Payable
          <div style='display:none' id='arrow-up-ap'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-ap'>&#9660;</div>
        </div>
      </h3>
      <div id='ap-content' class='d-hide'>
        <div class="form-group form-inline">
          <input type='text' class="form-control" id='start-date-ap' name='start-date-ap' value="">
          to
          <input type="text" class="form-control" name='end-date-ap' id='end-date-ap' value="">
          <button type="submit" class="btn btn-vprop-green" id='date-button-ap' style="margin-left: .5%;">Submit</button>
        </div>
        <table id="ap-table" class="table table-md bg-light nowrap table-bordered">
          <thead class="th-vprop-blue-medium">
            <tr>
              <th>Invoice Id</th>
              <th>Vendor</th>
              <th>Type</th>
              <th>File Name</th>
              <th>Date</th>
              <th>Preview</th>
              <th>Download</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="card" id="ar-content-card">
    <div class="card-body">
      <h3 style='cursor: pointer'>
        <div id='ar-header' class='content-header vprop-blue-text'>
          Accounts Receivable
          <div style='display:none' id='arrow-up-ar'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-ar'>&#9660;</div>
        </div>
      </h3> 
      <div id='ar-content' class='d-hide'>
        <div class="form-group form-inline">
          <input type='text' class="form-control" id='start-date-ar' name='start-date-ar' value="">
          to
          <input type="text" class="form-control" name='end-date-ar' id='end-date-ar' value="">
          <button type="submit" class="btn btn-vprop-green" id='date-button-ar' style="margin-left: .5%;">Submit</button>
        </div>
        <table id="ar-table" class="table table-md bg-light nowrap table-bordered">
          <thead class="th-vprop-blue-medium">
            <tr>
              <th>Invoice Id</th>
              <th>Customer</th>
              <th>Type Code</th>
              <th>File Name</th>
              <th>Date</th>
              <th>Download</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <div class="card" id="rc-content-card">
    <div class="card-body">
      <h3 style='cursor: pointer'>
        <div id='rc-header' class='content-header vprop-blue-text'>
          Rail Car Releases
          <div style='display:none' id='arrow-up-rc'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-rc'>&#9660;</div>
        </div>
      </h3> 
      <div id='rc-content' class='d-hide'>
        <div class="form-group form-inline">
          <input type='text' class="form-control" id='start-date-rc' name='start-date-rc' value="">
          to
          <input type="text" class="form-control" name='end-date-rc' id='end-date-rc' value="">
          <button type="submit" class="btn btn-vprop-green" id='date-button-rc' style="margin-left: .5%;">Submit</button>
        </div>
        <table id="rc-table" class="table table-md bg-light nowrap table-bordered">
          <thead class="th-vprop-blue-medium">
            <tr>
              <th>Release Number</th>
              <th>PO ID</th>
              <th>Customer</th>
              <th>File Name</th>
              <th>Date</th>
              <th>Download</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <div class="card" id="po-content-card">
    <div class="card-body">
      <h3 style='cursor: pointer'>
        <div id='po-header' class='content-header vprop-blue-text'>
          Purchase Order Attachments
          <div style='display:none' id='arrow-up-po'>&#9650;</div>
          <div style='display:inline-block' id='arrow-down-po'>&#9660;</div>
        </div>
      </h3> 
      <div id='po-content' class='d-hide'>
        <div class="form-group form-inline">
          <input type='text' class="form-control" id='start-date-po' name='start-date-po' value="">
          to
          <input type="text" class="form-control" name='end-date-po' id='end-date-po' value="">
          <button type="submit" class="btn btn-vprop-green" id='date-button-po' style="margin-left: .5%;">Submit</button>
        </div>
        <table id="po-table" class="table table-md bg-light nowrap table-bordered">
          <thead class="th-vprop-blue-medium">
            <tr>
              <th>PO ID</th>
              <th>Customer</th>
              <th>Product</th>
              <th>File Name</th>
              <th>Date</th>
              <th>Download</th>
              <th>Preview</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>



<script>
$(document).ready(function () {
  
    $("#start-date-ap").val('2014-07-31');
    $("#end-date-ap").val('2014-12-31') ;
    $("#start-date-ar").val('2012-06-07');
    $("#end-date-ar").val('2012-12-31') ;
    $("#start-date-rc").val('2014-03-19');
    $("#end-date-rc").val('2014-12-31') ;
    $("#start-date-po").val('2014-07-15');
    $("#end-date-po").val('2014-12-31') ;
    

    $("#start-date-ap").datetimepicker({timepicker: false, format: 'Y-m-d',minDate : '2013-09-06'});
    $("#end-date-ap").datetimepicker({timepicker: false, format: 'Y-m-d'});
    $("#start-date-ar").datetimepicker({timepicker: false, format: 'Y-m-d',minDate : '2012-06-07'});
    $("#end-date-ar").datetimepicker({timepicker: false, format: 'Y-m-d'});
    $("#start-date-rc").datetimepicker({timepicker: false, format: 'Y-m-d',minDate : '2014-03-19'});
    $("#end-date-rc").datetimepicker({timepicker: false, format: 'Y-m-d'});
    $("#start-date-rc").datetimepicker({timepicker: false, format: 'Y-m-d',minDate : '2014-07-15'});
    $("#end-date-rc").datetimepicker({timepicker: false, format: 'Y-m-d'});
  
    let apTable = getApDocs();
    let arTable = getArDocs();
    let rcTable = getRailReleases();
    let poTable = getPoDocs();
    
    $( "#date-button-ap" ).click(function() {
        $('#ap-table').dataTable().fnDestroy();  
        getApDocs();
      });
    $( "#date-button-ar" ).click(function() {
      $('#ar-table').dataTable().fnDestroy();
      getArDocs();
      });
    $( "#date-button-rc" ).click(function() {
      $('#rc-table').dataTable().fnDestroy();
      getRailReleases();
      });
     $( "#date-button-po" ).click(function() {
      $('#po-table').dataTable().fnDestroy();
      getRailReleases();
      });
      
    $('#ar-header').on('click', function () {
      $('#arrow-up-ar').toggleClass('display-inline-block ');
      $('#arrow-down-ar').toggle();
      $.when($('#ar-content').slideToggle()).then(function () {
          arTable.draw();    
        });
    });
    $('#ap-header').on('click', function () {
      $('#arrow-up-ap').toggleClass('display-inline-block ');
      $('#arrow-down-ap').toggle();   
      $.when($('#ap-content').slideToggle()).then(function () {
          apTable.draw();    
        });
    });
    $('#rc-header').on('click', function () {
      $('#arrow-up-rc').toggleClass('display-inline-block ');
      $('#arrow-down-rc').toggle();   
      $.when($('#rc-content').slideToggle()).then(function () {
          rcTable.draw();    
        });
    });
    $('#po-header').on('click', function () {
      $('#arrow-up-po').toggleClass('display-inline-block ');
      $('#arrow-down-po').toggle();   
      $.when($('#po-content').slideToggle()).then(function () {
          poTable.draw();    
        });
    });
      
  });
  
  function getApDocs(){
    
    let startDate =$('#start-date-ap').val();
    let endDate = $('#end-date-ap').val();
    var apTable = $('#ap-table').DataTable({
            ajax: {
                url: '../../Includes/Accounting/invoices_legacy_ap_get.php',
                dataSrc:'',
                dataType: 'json',
                scrollY:'400px',
                type: 'POST',
              data:
                {
                        start_date: startDate,
                        end_date: endDate
                }
              },
            scrollY: '600px',
            pageLength: 10,

            columns: [
                {data:"id"}, 
                {data: "vendor"},
                {data: "invoice_type"}, 
                {data: "path", render: function (data,row,meta)
                      {
                        if(data != null)
                        {
                        return data.substring(11);
                        }else{
                          return 'No File Found';
                        }
                      }
                    },
                {data: "date", render: function (data,row,meta)
                      {
                        if(data != null)
                        {
                        return data;
                        }else{
                          return 'No File Found';
                        }
                      }
                    },
                {data: "path", render: function (data,row,meta)
                    {

                      let docType = data.slice(-3).toLowerCase();
                      if(docType == 'txt')
                      {
                      return '<a class="text fancybox.iframe" href="../../Files/Accounting/LegacyAP/' + data + '"><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-eye text-primary"></i></span></button></div></a>';
                      }
                      else if (docType == 'pdf') 
                      {
                        return '<a class="link fpdf" data-type="iframe" href="../../Files/Accounting/LegacyAP/' + data + '"><div class="text-center"><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-eye text-primary"></i></span></button></div></div></a>';
                      }else{
                        return '<div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-ban text-danger"></i></span></button></div>';
                      }
                    }
                },    
                {data: 'path', render: function (data, row, meta)
                  {
                    if(data != null)
                    {
                      return '<a class="link" href="../../Files/Accounting/LegacyAP/' + data + '" download><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-download text-primary"></i></span></button></div></a>';
                     }
                     else
                     {
                       return "<div class='text-center'>No File Found</div>"
                     }
                  }
                }],           
                fnDrawCallback: function(){
                  $(".text").fancybox({
                      type: 'iframe'           
                      });               
                  $("a.fpdf").fancybox({
                      type: 'iframe',
                      'autoScale': true,
                      'autoDimensions': true     ,
                      css: {'background-color': '#fff000 !important'}
                      });
            }
    });
    return apTable;
  }
  function getArDocs(){
    let startDate =$('#start-date-ar').val();
    let endDate = $('#end-date-ar').val();
    var arTable = $('#ar-table').DataTable({
            ajax: {
                url: '../../Includes/Accounting/invoices_legacy_ar_get.php',
                dataSrc:'',
                dataType: 'json',
                scrollY:'400px',
                type: 'POST',
                data:
                {
                        start_date: startDate,
                        end_date: endDate
                }

              },
            scrollY: '600px',
            pageLength: 10,
            columns: [
                {data:"id"}, 
                {data: "customer"},
                {data: "type_code"},
                {data: "invoice_path", render: function (data,row,meta)
                      {
                        if(data != null)
                        {
                        return data.split(".")[1] + "." + data.split(".")[2] ;
                        }else{
                          return 'No File Found';
                        }
                      }
                    }, 
                {data: "date", render: function (data,row,meta)
                      {
                        if(data != null)
                        {
                        return data;
                        }else{
                          return 'No File Found';
                        }
                      }
                    },
                {data: 'invoice_path', render: function (data, row, meta)
                  {
                    if(data != null)
                    {
                      return '<a class="link" href="../../Files/Accounting/LegacyAR/' + data + '" download><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-download text-primary"></i></span></button></div></a>';
                     }
                     else
                     {
                       return "<div class='text-center'>No File Found</div>"
                     }
                  }
                }],

    });
    return arTable;
  }
  function getRailReleases(){
    let startDate =$('#start-date-rc').val();
    let endDate = $('#end-date-rc').val();
    var arTable = $('#rc-table').DataTable({
            ajax: {
                url: '../../Includes/Accounting/rail_car_releases_get.php',
                dataSrc:'',
                dataType: 'json',
                scrollY:'400px',
                type: 'POST',
                data:
                {
                        start_date: startDate,
                        end_date: endDate
                }

              },
            scrollY: '600px',
            pageLength: 10,
            columns: [
                {data:"release_no"}, 
                {data: "po_id"},
                {data: "customer"}, 
                {data: "path", render: function (data,row,meta)
                      {
                        if(data != null)
                        {
                        return data.split(".")[1] + "." + data.split(".")[2] ;
                        }else{
                          return 'No File Found';
                        }
                      }
                    },   
                {data: "date"},

                {data: 'path', render: function (data, row, meta)
                  {
                    if(data != null)
                    {
                      return '<a class="link" href="../../Files/Accounting/RailCarReleases/' + data + '" download><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-download text-primary"></i></span></button></div></a>';
                     }
                     else
                     {
                       return "<div class='text-center'>No File Found</div>"
                     }
                  }
                }],

    });
    return arTable;
  }
  function getPoDocs(){
    
    let startDate =$('#start-date-po').val();
    let endDate = $('#end-date-po').val();
    var poTable = $('#po-table').DataTable({
            ajax: {
                url: '../../Includes/Accounting/invoices_legacy_po_get.php',
                dataSrc:'',
                dataType: 'json',
                scrollY:'400px',
                type: 'POST',
              data:
                {
                        start_date: startDate,
                        end_date: endDate
                }
              },
            scrollY: '600px',
            pageLength: 10,
            columns: [
                {data:"po_id"}, 
                {data: "customer"},
                {data: "product"}, 
                {data: "path"},
                {data: "date_issued"},
                {data: "path", render: function (data,row,meta)
                  {
                    if(data != null)
                    {
                      return '<a class="link" href="../../Files/Accounting/PurchaseOrderAttachments/' + data + '" download><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-download text-primary"></i></span></button></div></a>';
                     }
                     else
                     {
                       return "<div class='text-center'>No File Found</div>"
                     }
                  }
                },    
                {data: 'path', render: function (data, row, meta)                  
                  {
                      let docType = data.slice(-3).toLowerCase();
                      if(docType == 'txt')
                      {
                      return '<a class="text fancybox.iframe" href="../../Files/Accounting/PurchaseOrderAttachments/' + data + '"><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-eye text-primary"></i></span></button></div></a>';
                      }
                      else if (docType == 'pdf') 
                      {
                        return '<a class="link fpdf" data-type="iframe" href="../../Files/Accounting/PurchaseOrderAttachments/' + data + '"><div class="text-center"><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-eye text-primary"></i></span></button></div></div></a>';
                      }else{
                        return '<div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-ban text-danger"></i></span></button></div>';
                      }
                    }
                }],           
                fnDrawCallback: function(){
                  $(".text").fancybox({
                      type: 'iframe'           
                      });               
                  $("a.fpdf").fancybox({
                      type: 'iframe',
                      'autoScale': true,
                      'autoDimensions': true,
                      css: {'background-color': '#fff000 !important'}
                      });
            }
    });
    return poTable;
  }
  
</script>