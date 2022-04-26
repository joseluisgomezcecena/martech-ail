</div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer 
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Smart Studios <?php echo date("Y") ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="index.php?logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="views/assets/vendor/jquery/jquery.min.js"></script>
  <script src="views/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="views/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!--charts-->
  <script src="views/assets/vendor/chart.js/Chart.js"></script>
  <script src="ajax/charts/piechart-actions.js"></script>
  <script src="ajax/charts/piechart-actions-tier.js"></script>
  <script src="ajax/charts/piechart-projects.js"></script>
  <script src="ajax/charts/piechart-tier.js"></script>
  <script src="ajax/charts/piechart-meetings.js"></script>
  <script src="ajax/alerts/alertnum.js"></script>
  <script src="ajax/alerts/alerttext.js"></script>

  
  <script src="ajax/alertstier/alertnum.js"></script>
  <script src="ajax/alertstier/alerttext.js"></script>
  <!--
  <script src="views/assets/js/demo/chart-area-demo.js"></script>
  <script src="views/assets/js/demo/chart-pie-demo.js"></script>
  
  <script src="views/assets/vendor/switch/switch.js"></script>
-->
  <!-- Custom scripts for all pages-->
  <script src="views/assets/js/sb-admin-2.min.js"></script>



  

  

  
  
  <script src="views/assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="views/assets/vendor/dropzone/dropzone.js"></script>
  <script src="views/assets/vendor/jqueryvalidate/jquery.validate.js"></script>
  <script src="views/assets/vendor/select2/js/select2.js"></script>
  <script src="views/assets/vendor/bootstrap-slider/slider.js"></script>

  <script src="ajax/users/usertable.js"></script>
  <script src="ajax/machines/machinestable.js"></script>
  <script src="ajax/main.js"></script>
  <script src="ajax/ajaxtables.js"></script>
  <script src="ajax/views.js"></script>

  <script>
    $("#ex13").slider({
      ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
      ticks_labels: ["0%", "$10%", "$20%", "$30%", "$40%", "50%", "60%", "70%", "80%", "90%", "100% COMPLETE"],
      ticks_snap_bounds: 30
    });
  </script>

  <script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2({
      });
    });

    $(document).ready(function() {
      $('.js-example-basic-multiple').select2(
   
      );
    });

    //$('#id_label_multiple1').val(['21', '129']);
    //$('#id_label_multiple1').trigger('change');

    

    //refresh select 2
    $("#refreshList").on('click', function(){

      $(".js-example-basic-single").select2("destroy");
      $(".js-example-basic-multiple").select2("destroy");  

      function buildagain()
      {
          $(".js-example-basic-single").select2();
          $(".js-example-basic-multiple").select2();
      }
      
    (function worker() {
        $.ajax({
            url: 'index.php?page=action_add', 
            success: function(data) {

              $("#userRefresh").load(location.href + " #userRefresh");
             
            },
            complete: function() {
            // Siguiente peticion de ajax cuando la actual este terminada
            setTimeout(buildagain, 100);
            buildagain();
            }
        });
    })();
  });


      






      



  </script>

  <?php 
  if($datatablesop == 2):
  ?>
  <!---exports only -->
  <script src="views/assets/vendor/datatablesbutton/datatables.js"></script>
  <script src="views/assets/vendor/datatablesbutton/buttons.js"></script>
  <script src="views/assets/vendor/datatablesbutton/flash.js"></script>
  <script src="views/assets/vendor/datatablesbutton/jszip.js"></script>
  <script src="views/assets/vendor/datatablesbutton/pdfmake.js"></script>
  <script src="views/assets/vendor/datatablesbutton/vfs.js"></script>
  <script src="views/assets/vendor/datatablesbutton/html5.js"></script>
  <script src="views/assets/vendor/datatablesbutton/print.js"></script>
  <script src="views/assets/vendor/datatables/fixed.js"></script>

  <?php 
  else:

  ?>
  <!-- Page level plugins -->
  <script src="views/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="views/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="views/assets/js/demo/datatables-demo.js"></script>
  

  <?php 
  endif;
  ?>
 

  <script>
    function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

    $("#imgInp").change(function() {
      readURL(this);
    });
</script>

<script>
$(document).ready(function() {

  $('#dataTableExcel').DataTable( {

      "scrollX": true,
      "bSort": false,
      "pageLength": 10,
      "scrollCollapse": true,
      "fixedColumns": true,
        "fixedColumns": {
        leftColumns: 3,
        },
    


      dom: 'Bfrtip',
      buttons: [
        
          {
              extend: 'excelHtml5',
              title: 'AIL Report MMW'
          },
          {
              extend: 'csvHtml5',
              title: 'AIL Report MMW '
          },
          {
              extend: 'pdfHtml5',
              orientation: 'landscape',
              title: 'AIL Report MMW ',
              customize: function (doc) {        
              doc.defaultStyle.fontSize = 8;}
          },
          {
              extend: 'copyHtml5',
              title: 'AIL Report MMW '
          }
      ]
     
     /*
        buttons: [{
        extend: 'collection',
        className: "btn btn-primary",
        text: 'Export',
        buttons:
        [
          {
          extend: "pdf", className: "btn-primary"
          },
          {
             extend: 'excelHtml5', "text":'Excel',"className": 'btn', 
              //extend: 'excelHtml5',
              title: 'Quarantine Report MMW'
          },
    ],
      }]
      */
  });

});//on ready end




$(document).ready(function() {
  $('#example1').DataTable( {

        "scrollX": true,
        "scrollY": false,
        "bSort": false,
        "pageLength": 10,
        "scrollCollapse": true,
    } );
} );





  /*
    (function worker() {
    $.ajax({
        url: 'index.php', 
        success: function(data) {

        $("#table1").load(location.href+" #table1>*","");
        $("#table2").load(location.href+" #table2>*","");

        },
        complete: function() {
        // Siguiente peticion de ajax cuando la actual este terminada
        setTimeout(worker, 2000);
        
        }
    });
})();
*/
  </script>
  
  <script type="text/javascript">
        // add row
        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="phase[]" class="form-control m-input" placeholder="Enter Phase" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });
  </script>


<script>
var form = $( "#imageUploadForm" );
form.validate();  
  
Dropzone.autoDiscover = false;
  
myDropzone = new Dropzone('div#imageUpload', {
    addRemoveLinks: true,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 3,
    paramName: 'file',
    clickable: true,
    url: 'functions/actions/uploads/ajax.php',
    init: function () {

        var myDropzone = this;
        // Update selector to match your button
        $("#uploaderBtn").click(function (e) {
         // alert("hi");
            e.preventDefault();
            if ( $("#imageUploadForm").valid() ) {
                myDropzone.processQueue();
            }
            return false;
        });

        this.on('sending', function (file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $("#imageUploadForm").serializeArray();
            $.each(data, function (key, el) {
                formData.append(el.name, el.value);
            });
            console.log(formData);

        });
    },
    error: function (file, response){
        if ($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        return _results;
    },
    successmultiple: function (file, response) {
        console.log(file, response);
        //$modal.modal("show");
        //alert("success1");
        $("#fileList").load(location.href + " #fileList");
        //alert("1");
        this.removeAllFiles(true);

    },
    completemultiple: function (file, response) {
        console.log(file, response, "completemultiple");
        //$modal.modal("show");
        //alert("2");
        
    },
    reset: function () {
        //alert("3");
        console.log("resetFiles");
        this.removeAllFiles(true);
    }
});

</script>










<script>
var form = $( "#imageUploadForm2" );
form.validate();  
  
Dropzone.autoDiscover = false;
  
myDropzone = new Dropzone('div#imageUpload2', {
    addRemoveLinks: true,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 3,
    paramName: 'file',
    clickable: true,
    url: 'functions/actions/uploads/ajax2.php',
    init: function () {

        var myDropzone = this;
        // Update selector to match your button
        $("#uploaderBtn2").click(function (e) {
         // alert("hi");
            e.preventDefault();
            if ( $("#imageUploadForm2").valid() ) {
                myDropzone.processQueue();
            }
            return false;
        });

        this.on('sending', function (file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $("#imageUploadForm2").serializeArray();
            $.each(data, function (key, el) {
                formData.append(el.name, el.value);
            });
            console.log(formData);

        });
    },
    error: function (file, response){
        if ($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        return _results;
    },
    successmultiple: function (file, response) {
        console.log(file, response);
        //$modal.modal("show");
        //alert("success1");
        $("#fileList").load(location.href + " #fileList");
        //alert("1");
        this.removeAllFiles(true);

    },
    completemultiple: function (file, response) {
        console.log(file, response, "completemultiple");
        //$modal.modal("show");
        //alert("2");
        
    },
    reset: function () {
        //alert("3");
        console.log("resetFiles");
        this.removeAllFiles(true);
    }
});

</script>












<script>



$(".phasesclass").on('change', function postinput(){
    alert("updated");
    $.ajax({
          type: 'POST',
          url: 'functions/projects/phases.php',
          data: ({ 
              "phase-id" : $(this).data("phase-id"),
              //"hr" : $(this).data("hr"), 
              "value" : $(this).val()
          }),
      }).done(function(responseData) {
        console.log(responseData);
    }).fail(function() {
        console.log('Failed');
    });   
});



$(".delete-phase").on('click', function postinput2(){
    alert("deleted");
    $.ajax({
          type: 'POST',
          url: 'functions/projects/phases_delete.php',
          data: ({ 
              "phase-id" : $(this).data("phase-id"),
              //"hr" : $(this).data("hr"), 
              //"value" : $(this).val()
          }),
      }).done(function(responseData) {
        $("#phasesold").load(location.href + " #phasesold");
        console.log(responseData);
    }).fail(function() {
        console.log('Failed');
    });   
});




</script>

<script>


$(".delete-file").on('click', function postinput2(){
    alert("delete");
    $.ajax({
          type: 'POST',
          url: 'functions/files/file_delete.php',
          data: ({ 
              "file-id" : $(this).data("file-id"),
              //"hr" : $(this).data("hr"), 
              //"value" : $(this).val()
          }),
      }).done(function(responseData) {
        $("#fileList").load(location.href + " #fileList");
        console.log(responseData);
    }).fail(function() {
        console.log('Failed');
    });   
});

</script>




<script>
$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});
</script>






</body>

</html>
