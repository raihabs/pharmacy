<!-- plugins:js -->
<script src="../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="../assets/vendors/chart.js/Chart.min.js"></script>
<script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="../assets/vendors/flot/jquery.flot.js"></script>
<script src="../assets/vendors/flot/jquery.flot.resize.js"></script>
<script src="../assets/vendors/flot/jquery.flot.categories.js"></script>
<script src="../assets/vendors/flot/jquery.flot.fillbetween.js"></script>
<script src="../assets/vendors/flot/jquery.flot.stack.js"></script>
<script src="../assets/vendors/flot/jquery.flot.pie.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="../assets/js/off-canvas.js"></script>
<script src="../assets/js/hoverable-collapse.js"></script>
<script src="../assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="../assets/js/dashboard.js"></script>
<!-- End custom js for this page -->


<script src="../assets/vendors/select2/select2.min.js"></script>
<script src="../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="../assets/js/file-upload.js"></script>
<script src="../assets/js/typeahead.js"></script>
<script src="../assets/js/select2.js"></script>

<!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->


<!-- 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->

<!-- sweetalert2 message -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script> -->



<!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->


<!-- Include jQuery and SweetAlert2 -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>




<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.25%.4/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->



<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  function printUserTable() {
    const iframe = document.getElementById('userPrintIframe');
    iframe.contentWindow.focus(); // Make sure the iframe content is focused
    iframe.contentWindow.print(); // Trigger the print dialog of the iframe content
  }

  $(document).ready(function() {
    $('.table-responsive table').DataTable({
      "ordering": false,
      retrieve: true,
      paging: true,
      pagingType: 'full_numbers',
      pagingType: 'full_numbers',
      "aLengthMenu": [
        [5, 10, 25, 50, 100, 200, 500, -1],
        [5, 10, 25, 50, 100, 200, 500, "All"]
      ],
      "iDisplayLength": 5,

    });



    $('#activeContent .table-responsive #table_active').DataTable({
      "ordering": false,
      retrieve: true,
      paging: true,
      pagingType: 'full_numbers',
      pagingType: 'full_numbers',
      "aLengthMenu": [
        [5, 10, 25, 50, 100, 200, 500, -1],
        [5, 10, 25, 50, 100, 200, 500, "All"]
      ],
      "iDisplayLength": 5,
    });

    $('#archiveContent .table-responsive #table_archive').DataTable({
      "ordering": false,
      retrieve: true,
      paging: true,
      pagingType: 'full_numbers',
      pagingType: 'full_numbers',
      "aLengthMenu": [
        [5, 10, 25, 50, 100, 200, 500, -1],
        [5, 10, 25, 50, 100, 200, 500, "All"]
      ],
      "iDisplayLength": 5,
    });



    let activeTableInitialized = false;
    let archiveTableInitialized = false;


    function initializeDataTable(selector) {
      if (!$.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable();
      }
    }

    // Initial setup for Active section
    initializeDataTable('#activeContent .table-responsive table');
    activeTableInitialized = true;

    $('#activeButton').click(function() {
      $('#archiveContent').hide();
      $('#activeContent').show();

      $('#activeButton').addClass('active-button');
      $('#archiveButton').removeClass('active-button');

      if (!activeTableInitialized) {
        initializeDataTable('#activeContent .table-responsive table');
        activeTableInitialized = true;
      }
    });

    $('#archiveButton').click(function() {
      $('#activeContent').hide();
      $('#archiveContent').show();

      $('#archiveButton').addClass('active-button');
      $('#activeButton').removeClass('active-button');

      if (!archiveTableInitialized) {
        initializeDataTable('#archiveContent .table-responsive table');
        archiveTableInitialized = true;
      }
    });


  });
</script>

<script>
  // Update Row
  $(document).ready(function() {
    $(document).on('click', '.inventory_edit', function() {

      var inventory_edit_id = $(this).val();

      $.ajax({
        type: "GET",
        url: "../getdata/product_data.php?inventory_edit_id=" + inventory_edit_id,
        success: function(response) {
          var res = jQuery.parseJSON(response);
          if (res.status == 200) {
            $('#pr_id').val(res.data.pr_id);
            $('#item_code').val(res.data.item_code);
            $('#quantity').val(res.data.quantity);
            $('#expiration_date').val(res.data.expiration_date);
            $('#remarks').val(res.data.remarks);
          }
          // $('#memo').html(data);
        }

      });
    });
  });


  // Update Row
  $(document).ready(function() {
    $(document).on('click', '.archive_edit', function() {

      var archive_edit_id = $(this).val();

      $.ajax({
        type: "GET",
        url: "../getdata/product_data.php?archive_edit_id=" + archive_edit_id,
        success: function(response) {
          var res = jQuery.parseJSON(response);
          if (res.status == 200) {
            $('#pr_id').val(res.data.pr_id);
            $('#item_code').val(res.data.item_code);
            $('#quantity').val(res.data.quantity);
            $('#expiration_date').val(res.data.expiration_date);
            $('#remarks').val(res.data.remarks);
          }
          // $('#memo').html(data);
        }

      });
    });
  });



  $(document).ready(function() {
    // new form update
    $(document).on('submit', '#updInventory', function(e) {
      e.preventDefault();
      // alert("äw");
      var formData = new FormData(this);
      formData.append("update_inventory", true);
      Swal.fire({
        title: 'Do you want to Update Product?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../user_process/product_process.php", //action
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = jQuery.parseJSON(response);
              console.log(res);
              if (res.status == 400) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 3000
                })
              } else if (res.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'SUCCESS',
                  text: res.msg,
                  timer: 2000
                }).then(function() {
                  location.reload();
                });
              }
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info').then(function() {
            location.reload();
          });
        }
      })

    });

  });

  $(document).ready(function() {
    // new form update
    $(document).on('submit', '#updArchive', function(e) {
      e.preventDefault();
      // alert("äw");
      var formData = new FormData(this);
      formData.append("update_archive", true);
      Swal.fire({
        title: 'Do you want to Update Product?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../user_process/product_process.php", //action
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = jQuery.parseJSON(response);
              console.log(res);
              if (res.status == 400) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 3000
                })
              } else if (res.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'SUCCESS',
                  text: res.msg,
                  timer: 2000
                }).then(function() {
                  location.reload();
                });
              }
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info').then(function() {
            location.reload();
          });
        }
      })

    });

  });
</script>



<script type="text/javascript">
  setTimeout(function() {
    $('#global-loader');
    setTimeout(function() {
      $("#global-loader").fadeOut("slow");
    }, 100);
  }, 500);

  // Update for User Password
  $(document).ready(function() {
    $(document).on('click', '.change_pass', function() {

      var edit_user_id = $(this).val();

      $.ajax({
        type: "GET",
        url: "../getdata/user_data.php?edit_user_id=" + edit_user_id,
        success: function(response) {
          var res = jQuery.parseJSON(response);
          if (res.status == 200) {
            $('#u_id').val(res.data.user_id);
            $('#user_username').val(res.data.username);
            // Hashing the password using a hashing algorithm (e.g., SHA-256)
            // var hashedPassword = sha256(res.data.password);
            // $('#user_password').val(res.data.password);
          }
          // $('#memo').html(data);
        }

      });
    });
  });


  $(document).ready(function() {
    // new form update
    $(document).on('submit', '#userPassword', function(e) {
      e.preventDefault();
      // alert("äw");
      var formData = new FormData(this);
      formData.append("user_Password", true);
      Swal.fire({
        title: 'Do you want to Update this User Password?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../user_process/user_process.php", //action
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = jQuery.parseJSON(response);
              if (res.status == 400) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 9000
                })
              } else if (res.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'SUCCESS',
                  text: res.msg,
                  timer: 9000
                }).then(function() {
                  location.reload();
                });
              }
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info').then(function() {
            location.reload();
          });
        }
      })

    });

  });
  $(document).ready(function() {
    // new form update
    $(document).on('submit', '#editInfo', function(e) {
      e.preventDefault();
      // alert("äw");
      var formData = new FormData(this);
      formData.append("update_user_information", true);
      Swal.fire({
        title: 'Do you want to update your details?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../user_process/user_process.php", //action
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = jQuery.parseJSON(response);
              if (res.status == 400) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 9000
                })
              } else if (res.status == 500) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 9000
                })
              } else if (res.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'SUCCESS',
                  text: res.msg,
                  timer: 9000
                }).then(function() {
                  location.reload();
                });
              }
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info').then(function() {
            location.reload();
          });
        }
      })

    });

  });


  $(document).ready(function() {
    // new form update
    $(document).on('submit', '#changePassword', function(e) {
      e.preventDefault();
      // alert("äw");
      var formData = new FormData(this);
      formData.append("update_user_password", true);
      Swal.fire({
        title: 'Do you want to update your password',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../user_process/user_process.php", //action
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = jQuery.parseJSON(response);
              if (res.status == 400) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 9000
                })
              } else if (res.status == 500) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 9000
                })
              } else if (res.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'SUCCESS',
                  text: res.msg,
                  timer: 9000
                }).then(function() {
                  location.reload();
                });
              }
            }
          })
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info').then(function() {
            location.reload();
          });
        }
      })

    });

  });




  // // Update for Files
  // $(document).ready(function() {
  //   $(document).on('click', '.account_edit', function() {

  //     var user_edit_id = $(this).val();

  //     $.ajax({
  //       type: "GET",
  //       url: "../getdata/user_data.php?user_edit_id=" + user_edit_id,
  //       success: function(response) {
  //         var res = jQuery.parseJSON(response);
  //         if (res.status == 200) {
  //           $('#user_id').val(res.data.user_id);
  //           $('#username').val(res.data.username);
  //           $('#firstname').val(res.data.firstname);
  //           $('#lastname').val(res.data.lastname);
  //           $('#email').val(res.data.email);
  //           $('#phone').val(res.data.phone);
  //           $('#address').val(res.data.address);
  //           $('#birthday').val(res.data.birthday);
  //           $('#role').val(res.data.role);
  //         }
  //         // $('#memo').html(data);
  //       }

  //     });
  //   });
  // });



  



        $(document).ready(function() {
          // new form update
          $(document).on('submit', '#updAccount', function(e) {
            e.preventDefault();
            // alert("äw");
            var formData = new FormData(this);
            formData.append("update_account", true);
            Swal.fire({
              title: 'Do you want to Update Account?',
              showCancelButton: true,
              confirmButtonText: 'Update',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  url: "../user_process/user_process.php", //action
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 400) {
                      Swal.fire({
                        icon: 'warning',
                        title: 'Something Went Wrong.',
                        text: res.msg,
                        timer: 3000
                      })
                    } else if (res.status == 200) {
                      Swal.fire({
                        icon: 'success',
                        title: 'SUCCESS',
                        text: res.msg,
                        timer: 2000
                      }).then(function() {
                        location.reload();
                      });
                    }
                  }
                })
              } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info').then(function() {
                  location.reload();
                });
              }
            })

          });

        });

        // Set Status to INACTIVE
        $(document).ready(function() {
          $('.account_delete1').click(function() {
            var del_id1 = $(this).attr('id');
            var $ele = $(this).parent().parent();
            Swal.fire({
              title: 'Are you Sure?',
              text: "You want to update the user status into inactive?",
              // showDenyButton: true,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#CD853F',
              confirmButtonText: 'Yes, Update Status',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $.ajax({
                  type: 'POST',
                  url: '../user_process/user_process.php',
                  data: {
                    del_id1: del_id1
                  },
                  success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 400) {
                      Swal.fire({
                        icon: 'warning',
                        title: 'Something Went Wrong.',
                        text: res.msg,
                        timer: 3000
                      }).then(function() {
                        location.reload();
                      });
                    } else if (res.status == 200) {
                      Swal.fire({
                        icon: 'success',
                        title: 'SUCCESS',
                        text: res.msg,
                        timer: 2000
                      }).then(function() {
                        location.reload();
                      });
                    }
                  }
                })
              } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info').then(function() {
                  location.reload();
                });
              }
            })
          });
        });


        // Set Status to ACTIVE
        $(document).ready(function() {
          $('.account_delete2').click(function() {
            var del_id2 = $(this).attr('id');
            var $ele = $(this).parent().parent();
            Swal.fire({
              title: 'Are you Sure?',
              text: "You want to update the user status into active?",
              // showDenyButton: true,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#CD853F',
              confirmButtonText: 'Yes, Update Status',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $.ajax({
                  type: 'POST',
                  url: '../user_process/user_process.php',
                  data: {
                    del_id2: del_id2
                  },
                  success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 400) {
                      Swal.fire({
                        icon: 'warning',
                        title: 'Something Went Wrong.',
                        text: res.msg,
                        timer: 3000
                      }).then(function() {
                        location.reload();
                      });
                    } else if (res.status == 200) {
                      Swal.fire({
                        icon: 'success',
                        title: 'SUCCESS',
                        text: res.msg,
                        timer: 2000
                      }).then(function() {
                        location.reload();
                      });
                    }
                  }
                })
              } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info').then(function() {
                  location.reload();
                });
              }
            })
          });
        });
</script>





<!-- products -->