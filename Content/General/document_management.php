<?php
/* * *****************************************************************************************************************************************
 * File Name: document_management.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 10/25/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');
require_once('../../Includes/General/document_functions.php');

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$departmentSql = 'CALL sp_adm_UserDeptGet(' . $user_id . ')';
$departmentResults = dbmysqli()->query($departmentSql);
while($result = mysqli_fetch_assoc($departmentResults))
  {
    $departmentId = $result['main_department_id'];
    $departmentName = $result['name'];
  }

//echo (print_r($userPermissionsArray['vista']));

$maxPermArry = [];

if(isset($userPermissionsArray['vista']['granbury']))
  {
    $maxPermArry[] = max($userPermissionsArray['vista']['granbury']);
  }
if(isset($userPermissionsArray['vista']['tolar']))
  {
    $maxPermArry[] = max($userPermissionsArray['vista']['tolar']);
  }
if(isset($userPermissionsArray['vista']['west_texas']))
  {
    $maxPermArry[] = max($userPermissionsArray['vista']['west_texas']);
  }

  $maxPerm = max($maxPermArry);
  
  $permissionJson = json_encode($userPermissionsArray);

//========================================================================================== END PHP
?>
<script src="../../Includes/jquery.dm-uploader.min.js"></script>
<link rel="stylesheet" href="../../Includes/uploader-master/dist/css/jquery.dm-uploader.min.css">
<link rel="stylesheet" href="../../Includes/uploader-master/demo/styles.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/custom-data-source/dom-text.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/dataRender/ellipsis.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.css" type="text/css" media="screen" />

<style>
  .modal {
 overflow-y: auto;
}

.modal-open {
 overflow: auto;
}

.fancybox-slide--iframe .fancybox-content {
    background: #fff0 !important;
}
</style>

<div class="container-fluid">
    <div class="card" id="main-content-card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist" id="card-tab">
                <li class="nav-item">
                    <a class="nav-link active" role="tab" data-toggle="tab" id="files-tab" href="#files-table">Files</a>
                </li>
                <?php if($maxPerm >= 4) { ?>
                <li class="nav-item">
                    <a class="nav-link" role="tab" data-toggle="tab" id="upload-tab" href="#upload">Upload</a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="card-tab-content">
                <div class="tab-pane fade show active" id="files-table" role="tabpanel">
                    <div class="card">
                        <div class="card-header" id="table-card-header">

                        </div>
                        <div class="card-body">
                            <table id="general-table" class="table table-md bg-light nowrap">
                                <thead class="th-vprop-blue-medium">
                                <tr>
                                    <th>Id</th>
                                    <th>File Name</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Size</th>
                                    <th>Info</th>
                                    <th>Download</th>
                                    <th>Preview</th>
                                    <th>Uploaded By</th>
                                    <th>Uses</th>
                                    <th>Upload Date</th>
                                    <th>Edit</th>
                                    <th>Replace</th>
                                    <th>Delete</th>
                                    <!--<th>Request</th>-->
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-footer pb-0" id="table-card-footer">
                        </div>
                    </div>
                </div>
              <?php if($maxPerm >= 4) { ?>
              <div class="tab-pane fade show " id="upload" role="tabpanel">
                <div class="row">
                  <div class="col-md-6 col-sm-12">

                    <div id="drop-area" class="dm-uploader p-5 text-center">
                      <h3 class="mb-5 mt-5 text-muted">Drag &amp; drop File here</h3>
                      <div class="btn btn-primary btn-block mb-5">
                        <span>Open the file Browser</span>
                        <input type="file" title="Click to add Files" name='file' id='file-input-primary'>
                      </div>    
                    </div>

                    <!--<div class="col-12">-->
                      <div id ='file-data' class="card h-50 d-hide ">
                        <div class="card-header ">
                          File Details    
                        </div>
                        <div class ='card-body'>
                          
                          <div class="alert alert-success" style="display:none" id="msg"></div>
                          <div class="alert alert-danger" style="display:none" id="failuremsg"></div>
                          <label>Description: </label><input class='form-control' type='text' id='file-description'>
                          <br>
                          <input type="hidden" id="dept-hidden" value="<?php echo $departmentId; ?>">
                          <label>Category: </label>
                          <select class='form-control' id="category-select">
                          </select>
                          <br>
                          <button id='category-button' class='btn btn-primary'>New Category</button>
                          <br><br>
                          <button id='upload-button' class='btn btn-vprop-green'>Upload</button>
                          <button id='cancel-button' class='btn btn-danger float-right'>Cancel</button>
                        </div>
                      </div>
                    <!--</div>-->
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="card h-50">
                      <div class="card-header">
                        File List
                      </div>
                      <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
                        <li class="text-muted text-center empty">No files uploaded.</li>
                      </ul>
                    </div>
                  </div>
                  <!--script for uploader widget-->
                  <script type="text/html" id="files-template">
                    <li class="media">
                      <div class="media-body mb-1">
                        <p class="mb-2">
                          <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
                        </p>
                        <div class="progress mb-2">
                          <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                               role="progressbar"
                               style="width: 0%" 
                               aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                          </div>
                        </div>
                        <hr class="mt-1 mb-1" />
                      </div>
                    </li>
                    </script>
                  </div>
                </div>
              <?php }?>
            </div>
        </div>
    </div>
</div>
<?php if($maxPerm >= 4) { ?>
<!--file edit modal-->
<div class="modal fade" id="file-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employee-modal-title">Edit File Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                  <div class="alert alert-danger" style="display:none" id="failure-msg-file-edit"></div>
                  <div class="alert alert-success" style="display:none" id="msg-file-edit"></div>
                  <input type="hidden" id="file-edit-department" value="">
                  <input type="hidden" id="file-edit-id" value="">
                    <div class="form-group col-xl-12">
                        <label for="file-edit-description">Description</label>
                        <input autocomplete="off" id="file-edit-description" class="form-control">
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="file-edit-category">Category</label>
                        <select id="file-edit-category" class="form-control">
                        </select>
                        <br>
                    <button id='category-button-modal' class='btn btn-primary'>New Category</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium update-employee-btn" id="edit-file-submit-btn">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--file replace modal-->
<div class="modal fade" id="file-replace" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employee-modal-title">Replace File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>          
      <div class="modal-body">
          <div class="form-row">
            <div class="alert alert-danger" style="display:none" id="error-replace"></div>
            <div class="alert alert-success" style="display:none" id="msg-replace"></div>
            <input type='hidden' id='old-path' value="">
            <input type='hidden' id='file-id-modal' value="">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" id="file-upload-button">Browse...</button>
                <label><input type="file" id='upload-input-modal' name='file' style="display:none ;"></label>
              </div>
              <input type="text" id='filename-input-modal' class="form-control" readonly>
            </div>
          </div> 
          <div class="modal-footer">
            <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-vprop-blue-medium update-employee-btn d-hide" id="replace-file-submit-btn">Save changes</button>
          </div>       
      </div>
    </div>
  </div>
</div>
<!--file delete modal-->
<div class="modal fade" id="file-delete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employee-modal-title">Delete File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="delete-id-modal"  value="">
              <input type="hidden" id="delete-path-modal"  value="">
              <P id="delete-text">
              </P>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Cancel</button>
                <button id='delete-button-modal' class='btn btn-danger float-right'>Delete</button>
            </div>
        </div>
    </div>
</div>
<!--category modal-->
<div class="modal fade" id="category-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employee-modal-title">New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
              <div class="alert alert-danger" style="display:none" id="failure-msg-category"></div>
              <div class="alert alert-success" style="display:none" id="msg-category"></div>
              <div class="form-row">

                <div class="form-group col-xl-12">
                  <input type="hidden" id="permission-input" value="">
                  <input type="hidden" id="department-input-category" value="">
                  <label for="category-title-input">Title</label>
                  <input autocomplete="off" id="category-title-input" class="form-control">
                </div>
                <label>Permission Level:</label>
                <div class="form-group col-xl-12">
                        <select id="permission-select" class="form-control">
                          <option value="-1">Select a permission level...</option>
                          <option value="0">0 Read Only</option>
                          <option value="1">1 Standard</option>
                          <option value="2">2 Shift Lead</option>
                          <option value="3">3 Manager</option>
                          <option value="4">4 Administrator</option>
                          
                        </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium update-employee-btn" id="category-submit-btn">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php }?>
<script>

window.$global = {
  fileId : null,
  departmentId :<?php echo $departmentId; ?>,
  departmentName: "<?php echo $departmentName ?>",
  userId:<?php echo $user_id; ?>,
  username:'<?php echo $username; ?>',
  permissionArry:<?php echo $permissionJson; ?>,
  maxPerm:<?php echo $maxPerm; ?>};

$(document).ready(function () {

var userData = [<?php echo $permissionJson; ?>];
var formData = {};

formData['departmentId'] = $global.departmentId;
formData['departmentName'] = $global.departmentName;
formData['permArry'] = userData;
formData = JSON.stringify(formData);

  let generalTable = $('#general-table').DataTable({
            ajax: {
                url: '../../Includes/General/files_get.php',
                dataSrc:'',
                dataType: 'json',
                type: 'POST',
                scrollY:'400px',
               data:{formData},                  
              },
            scrollY: '600px',
            pageLength: 10,
            fnDrawCallback: function(){
             $('[data-toggle="popover"]').popover(
                     {
                       html: true
                     });   
              $("a.fimage").fancybox({
                  type: 'image',
                  'autoScale': true,
                  'autoDimensions': true
                  
                  });
                  
              $("a.fpdf").fancybox({
                  type: 'iframe',
                  css: {'background-color': '#fff0 !important'}
                  });
            },
            columns: [
                {data:"id", visible:false},
                {
                  data: "doc_name", render: function (data, row)
                    {
                      return ellipsis(data,15);
                    }
                },
                {data: "doc_description", render: function (data, row)
                    {
                      return ellipsis(data,15);
                    }
                    },
                {data: "doc_type"},
                {data: "cat_name"},
                {data: "doc_size" , visible:false, render: function (data)
                  {
                     let size = (data/1024).toFixed(2);
                     if(size >= 1024)
                     {
                        size = (size/1024).toFixed(2)
                        return size + ' MB';
                     } 
                     else
                      {
                        return size + ' KB';
                      }
                     
                  }
    
                },
                {
                  data: "doc_size", render: function (data, row, meta)
                    {
                     let sizeStr;
                    let size = (data/1024).toFixed(2);
                     if(size >= 1024)
                     {
                        size = (size/1024).toFixed(2)
                        sizeStr = size + ' MB';
                     } 
                     else
                      {
                        sizeStr =  size + ' KB';
                      }
                      let dataContent ="Uploader: " + meta.username + "<br> Upload Date: " + meta.create_date + "<br> Size: " + sizeStr +"<br> Uses: " +meta.uses; 
                      return '<div class="text-center">\n\
                                <button class="btn bg-transparent del-btn" style="background-color:transparent;border-color:transparent;" data-toggle="popover" data-content = "' + dataContent +'">\n\
                                  <span><i class="fas fa-info-circle text-primary"></i></span>\n\
                                </button>\n\
                              </div>';
                    }
                },
                {render: function (data,row,meta)
                  {
                    return '<a class="link" href="' + data + '" download><div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;"><span><i class="fas fa-download text-primary"></i></span></button></div></a>';
                  }
                 },
                {
                  data: "doc_path", render: function (data,row,meta)
                    {
                      if(meta.doc_type == 'Image')
                      {
                      return '<a class="link fimage"data-type href="' + data + '"><div class="text-center" >Preview</div></a>';
                      }else if (meta.doc_type == 'PDF')
                      {
                        return '<a class="link fpdf" data-type="iframe" href="' + data + '"><div class="text-center">Preview</div></a>';
                      }else{
                        return '<a class="link" href="' + data + '"><div class="text-center">Download</div></a>';
                      }
                    }
                },
                {data: "username", visible:false},
                {data: "uses", visible:false},
                {data: "create_date", visible:false},
                {
                    render: function (row) {
                        return '<div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;" data-toggle="modal" data-target="#file-edit"><span><i class="fas fa-edit text-success"></i></span></button></div>';
                    }
                },
                {
                    render: function (row) {
                        return '<div class="text-center"><button class="btn bg-transparent rep-btn" style="background-color:transparent;border-color:transparent;" data-toggle="modal" data-target="#file-replace"><span><i class="fas fa-upload text-primary"></i></span></button></div>';
                    }
                },
                {
                    render: function (row) {
                        return '<div class="text-center"><button class="btn bg-transparent del-btn" style="background-color:transparent;border-color:transparent;" data-toggle="modal" data-target="#file-delete"><span><i class="fas fa-trash-alt text-danger"></i></span></button></div>';
                    }
                }],
                order: [[10, 'desc']]
                
        });
  generalTable.on('click', 'tbody .edit-btn', function () {
            let e = generalTable.row($(this).closest('tr')).data();
            
            $.when(getCategories($global.departmentId)).then(function() {
                $('#file-edit-category').val(e.category_id);
             });
              
            $('#file-edit-description').val(e.doc_description);
            $('#file-edit-department').val(e.dept_id);
            $('#file-edit-id').val(e.id);
        });
  generalTable.on('click', 'tbody .del-btn', function () {

            let e = generalTable.row($(this).closest('tr')).data();
            let delText = "Are you sure you want to delete " + e.doc_name + "?";
            $('#delete-id-modal').val(e.id)
            $('#delete-path-modal').val(e.doc_path)
            $('#delete-text').text(delText);
        });
  generalTable.on('click', 'tbody .link', function () {

            let e = generalTable.row($(this).closest('tr')).data();
            let id = e.id;
            $.ajax
                    ({
                      dataType: "html",
                      type: 'POST',
                      url: '../../Includes/General/file_update_uses.php',
                      data:
                              {
                                id:id
                              },
                      success: function (response) {
                        generalTable.ajax.reload();
                        generalTable.columns.adjust();
                        }
                    });
    });
  generalTable.on('click', 'tbody .rep-btn', function () {
            
            $('#error-replace').hide();
            $("#upload-input-modal").val('');
            $('#filename-input-modal').val('');
            let e = generalTable.row($(this).closest('tr')).data();
            $('#file-id-modal').val(e.id);
            $('#old-path').val(e.doc_path);

    });
  if($global.maxPerm <= 3)
    {
      generalTable.columns([-3,-2,-1]).visible( false, false );
      generalTable.columns.adjust().draw( false );
    }

  $('#drop-area').dmUploader({ 
  url: '../../Includes/General/upload_document.php',
    maxFileSize: 5000000, //  5Megs ,
    auto: false,
    multiple: false,
    onDragEnter: function(){
      // Happens when dragging something over the DnD area
      this.addClass('active');
    },
    onDragLeave: function(){
      // Happens when dragging something OUT of the DnD area
      this.removeClass('active');
    },
    onNewFile: function(id, file){
      // When a new file is added using the file selector or the DnD area
      ui_multi_add_file(id, file);
      $global.fileId = id;
      $('#drop-area').hide();
      $('#file-data').show('slow');
     var filename = $('#file-input-primary').val();
     var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
        filename = filename.replace(/\..+$/, '');
    }
    $('#file-description').val(filename);
    getCategories($global.departmentId);
    },
    onBeforeUpload: function(id){
      // about to start uploading a file
      ui_multi_update_file_progress(id, 0, '', true);
      ui_multi_update_file_status(id, 'uploading', 'Uploading...');
    },
    onUploadProgress: function(id, percent){
      // Updating file progress
      ui_multi_update_file_progress(id, percent);
    },
    onUploadSuccess: function(id, data){
      // A file was successfully uploaded
     $('#file-description').val('');
      ui_multi_update_file_status(id, 'success', 'Upload Complete');
      ui_multi_update_file_progress(id, 100, 'success', false);
      $("#drop-area").dmUploader("reset");     
      $('#drop-area').show('slow');
      $('#file-data').hide();
    },
    onUploadError: function(id, xhr, status, message){
      // Happens when an upload error happens
      ui_multi_update_file_status(id, 'danger', message);
      ui_multi_update_file_progress(id, 0, 'danger', false);    
      $("#drop-area").dmUploader("reset");      
      $('#drop-area').show('slow');
      $('#file-description').val('');
      $('#file-data').hide();
    }
  });
  $("#upload-button").click(function() {
    let description = $('#file-description').val();
    let department = $('#dept-hidden').val();
    let category = $('#category-select').val()
    
    if (description == "") {
            $('#failuremsg').html("Description cannot be blank").fadeIn('slow')
            $('#failuremsg').delay(3000).fadeOut('slow');
            return;
        }
    if(parseInt(category) === -1){
        $('#failuremsg').html("Please Select a category").fadeIn('slow')
        $('#failuremsg').delay(3000).fadeOut('slow');
        return;
    }
    $('#drop-area').data('dmUploader').settings.extraData = {
        description: description,
        department: department,
        category : category,
        userId: $global.userId,
        username: $global.username
    };
    $('#drop-area').dmUploader("start");

});  
  $("#cancel-button").click(function() {
      ui_multi_update_file_status($global.fileId, 'danger', 'Canceled');
      ui_multi_update_file_progress($global.fileId, 0, 'danger', false);   
      $("#drop-area").dmUploader("cancel",$global.fileId);      
      $('#file-description').val(''); 
      $('#drop-area').show('slow');
      $('#file-data').hide();
});
  
  $('#delete-button-modal').click(function() {
     let id = $('#delete-id-modal').val()
     let doc_path = $('#delete-path-modal').val()
      $.ajax
        ({
          dataType: "html",
          type: 'POST',
          url: '../../Includes/General/file_delete.php',
          data:
                  {
                    id:id,
                    doc_path:doc_path,
                    user_id:$global.userId
                  },
            success: function (response) {
                  generalTable.ajax.reload();
                  generalTable.columns.adjust();
              }
        });
        $('#file-delete').modal('hide');
});
  $('#edit-file-submit-btn').click(function(){ 
    
    let id = $('#file-edit-id').val()
    let description = $('#file-edit-description').val()
    let category = $('#file-edit-category').val()
    //console.log(category);
    let department = $('#file-edit-department').val()
      $.ajax
        ({
          dataType: "html",
          type: 'POST',
          url: '../../Includes/General/file_edit_info.php',
          data:
                  {
                    id:id,
                    description:description,
                    category:category,
                    department:department,                    
                    user_id:$global.userId
                  },
            success: function (response) {
                  // $('#msg').html(data).fadeIn('slow');
                  $('#msg-file-edit').html("Edited file successfully").fadeIn('slow') //also show a success message
                  $('#msg-file-edit').fadeOut('slow')
                  setTimeout(function() {$('#file-edit').modal('hide');}, 3000);
                  generalTable.ajax.reload();
                  generalTable.columns.adjust();
              }
        });
        $('#file-delete').modal('hide');
    
    
    });
    
  $("#file-upload-button").click(function(){ 
    
    $('#error-replace').hide();
    $("#upload-input-modal").click();

  });
  $('#upload-input-modal').change(function() {
    var filename = $(this).val();
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);

    }
    $('#filename-input-modal').val(filename);
    $('#replace-file-submit-btn').show('slow');

    

});
  $('#replace-file-submit-btn').click(function(){ 
//    $('#file-replace').modal('hide');    

    var file = $('#upload-input-modal').prop('files')[0];
    var oldPath = $('#old-path').val();
    var fileId = $('#file-id-modal').val()
    var filename = $('#filename-input-modal').val();

    var formData = new FormData();
    formData.append("file", file);
    formData.append('oldPath' ,oldPath);
    formData.append('fileId' ,fileId);
    formData.append('filename' ,filename);
    formData.append('username', $global.username)
    formData.append('userId', $global.userId)
    
    $.ajax
    
        ({
          dataType: "html",
          type: 'POST',
          processData: false,
          contentType: false,
          cache:false,
          url: '../../Includes/General/file_replace.php',
          data:formData,
          success: function (response) {

                  $('#msg-replace').html("Replaced File successfully").fadeIn('slow') //also show a success message
                  $('#msg-replace').fadeOut('slow')
                  generalTable.ajax.reload();
                  generalTable.columns.adjust();
                  setTimeout(function() {$('#file-replace').modal('hide');}, 3000);
              },
         error: function (error) {
           let errorMsg =JSON.parse(error.responseText);
           console.log(errorMsg);
                  $('#error-replace').html(errorMsg.message).fadeIn('slow') //also show a success message
//                  $('#error-replace').delay(4000).hide();
         }
        });
    
  });
  
  $('#category-button, #category-button-modal').click(function(){ 
    
    $('#permission-input').val($global.departmentName.toLowerCase());
    $('#department-input-category').val($global.departmentId); 
    $('#category-modal').modal('show');
    
  });
  $('#category-submit-btn').click(function(){ 
     let title = $('#category-title-input').val()
     let permissionLevel = $('#permission-select').val()
     let permission = $('#permission-input').val()
     let departmentId = $('#department-input-category').val()
     
     if(title=='')
     {
        $('#failure-msg-category').html("Title Cannot Be Blank").fadeIn('slow'); //also show a success message
        $('#failure-msg-category').fadeOut('slow');
        return;
     }
     
          
     if(permissionLevel == -1)
     {
        $('#failure-msg-category').html("Please choose a permission level").fadeIn('slow'); //also show a success message
        $('#failure-msg-category').fadeOut('slow');
        return;
     }
     
      $.ajax
        ({
          dataType: "html",
          type: 'POST',
          url: '../../Includes/General/category_add.php',
          data:
                  {
                    title:title,
                    permissionLevel:permissionLevel,
                    departmentId:departmentId,
                    permission:permission,
                    user_id:$global.userId
                  },
            success: function (response) {
                  // $('#msg').html(data).fadeIn('slow');
                  $('#msg-category').html("Added category successfully").fadeIn('slow') //also show a success message
                  $('#msg-category').fadeOut('slow')
                  setTimeout(function() {$('#category-modal').modal('hide');}, 3000);
                  getCategories($global.departmentId);
              }
        });
//
//    $('#category-modal').modal('hide');
  });
  
  $('.page-link').click(function(){ 
    
    $("a.fbox").fancybox();

  });
  
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  generalTable.ajax.reload();
  generalTable.columns.adjust();
})


});



// Creates a new file and add it to our list
function ui_multi_add_file(id, file)
{
  var template = $('#files-template').text();
  template = template.replace('%%filename%%', file.name);

  template = $(template);
  template.prop('id', 'uploaderFile' + id);
  template.data('file-id', id);

  $('#files').find('li.empty').fadeOut(); // remove the 'no files yet'
  $('#files').prepend(template);
}

// Changes the status messages on our list
function ui_multi_update_file_status(id, status, message)
{
  $('#uploaderFile' + id).find('span').html(message).prop('class', 'status text-' + status);
}

// Updates a file progress, depending on the parameters it may animate it or change the color.
function ui_multi_update_file_progress(id, percent, color, active)
{
  color = (typeof color === 'undefined' ? false : color);
  active = (typeof active === 'undefined' ? true : active);

  var bar = $('#uploaderFile' + id).find('div.progress-bar');

  bar.width(percent + '%').attr('aria-valuenow', percent);
  bar.toggleClass('progress-bar-striped progress-bar-animated', active);

  if (percent === 0){
    bar.html('');
  } else {
    bar.html(percent + '%');
  }

  if (color !== false){
    bar.removeClass('bg-success bg-info bg-warning bg-danger');
    bar.addClass('bg-' + color);
  }
}
 
 function ellipsis(data,length)
 {
    if(data.length > length){
     return '<p href="#" title="'+ data + '">' + data.substr( 0, length )+ '...</p>'
     }
     else
     {
       return '<p href="#" title="'+ data + '">' + data + '</p>'
     }
  }
 
 function getCategories(departmentId)
 {
    $('#category-select, #file-edit-category').children('option').remove();
    $.ajax({
     url: '../../Includes/General/categories_get.php',
     type: 'POST',
     data: {departmentId: departmentId},
     success: function (response) {
        
         $('#category-select ,#file-edit-category').append('<option value="-1">Select a category...</option>');
         $.each(JSON.parse(response), function (key, value) {
             $('#category-select, #file-edit-category').append('<option value="' + value.id + '">' + value.cat_name + '</option>');
         });
     }
 });
 }
 </script>
<!-- HTML -->