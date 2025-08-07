
   let jobid=null;
     let rowid=null;  
     let candidateid=null;
     let employerid=null;
    const modal = document.getElementById('myModal-invoice');
    const openModalBtns = document.querySelectorAll('.generate-invoice-button');
    const closeBtn = document.querySelector('.close');
   
    // Add click event listeners to each button
    openModalBtns.forEach(function(openModalBtn) {
      openModalBtn.addEventListener('click', function() {
       
        const rowid2=this.getAttribute('data-row-id');
        const jobid2=this.getAttribute('data-job-id');
        const candidateid2=this.getAttribute('data-candidate-id');
        const employerid2=this.getAttribute('data-employer-id');
        rowid=rowid2;
        jobid=jobid2;
        candidateid=candidateid2;
        employerid=employerid2;
       
        const status = this.getAttribute('data-status');
      
       
       if (status === 'yes') {
        // Display a confirmation dialog
        const confirmed = confirm('Do you want to send the invoice again?');
        if (confirmed) {
          // User confirmed, display the modal
          modal.style.display = 'block';
        }
      } else {
        // Status is not "Yes," perform the action (e.g., open the modal) directly
        modal.style.display = 'block';
      }
    });
  });

    // Close the modal when the close button is clicked
    if (closeBtn && modal) {
      closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
      });
    };
    // Handle form submission
 /*

    function deleteInvoices() {

      // Confirm the deletion
      var confirmDelete = confirm("Are you sure you want to delete all invoices?");
      var deleteButton = jQuery('#delete_invoices');
    // 
  
      if (confirmDelete) {
        deleteButton.text('Deleting...');
          // Send an AJAX request to delete the files
          jQuery.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                  action: 'delete_invoices', // This will be used to identify the AJAX action
              },
              success: function (response) {
                if (response.trim().toLowerCase() === 'success') {
                  
                  // Refresh the page or update the UI as needed
                  alert('Invoices deleted successfully.');
                
                  location.reload(); // Refresh the page
              } else {
                   
                      alert('Error deleting invoices.');
                     location.reload();   
                  }
              },
              error: function (error) {
                  alert('Error deleting invoices.');
              }
          });
      }
  }

    // Function to fetch and display the total file size
function showTotalFileSize() {
  jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
          action: 'get_invoices_folder_size', // AJAX action to get folder size
      },
      success: function (response) {
          // Display the total file size next to the button
          var totalSize = parseInt(response);
          if (!isNaN(totalSize)) {
              jQuery('#delete_invoices').before('<span style="margin-left: 10px;">Total File Size: ' + formatFileSize(totalSize) + '</span>');
          }
      },
      error: function (error) {
          console.error('Error fetching folder size.');
      },
  });
}

// Helper function to format file size for display
function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes';

  var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
  var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));

  return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

// Call the showTotalFileSize function to display the total file size when the page loads
showTotalFileSize();
*/
(function ($) {


 // Function to handle invoice deletion


    "use strict";
       $('.my-color-field').wpColorPicker();
    if ($('#indeed_import_form').length > 0) {     
       $('#indeed_import_form').on('submit', function (e) {
             e.preventDefault();      
             
             var btn_txt   =   $('#import_job_submit').html();
            $('#import_job_submit').html('importing...');
            $("#import_job_submit").attr("disabled", true); 
        
            $.post(ajaxurl, {
                action: 'sb_import_indeed_job',
                sb_indeed_param: $("#indeed_import_form").serialize(),
            }).done(function (response) {
                
                  $('#import_job_submit').html(btn_txt);
                  $("#import_job_submit").attr("disabled", false);                      
                var res = response.split("|");     
            if(res[0] ==  "0"){    
                alert(res[1]);
            }
           else if(res[0] ==  "1"){    
                alert(res[1]);
            }
             else if(res[0] ==  "2"){    
                alert(res[1]);
            }
             else if(res[0] ==  "3"){    
                alert(res[1]);
            }
             else if(res[0] ==  "4"){    
                alert(res[1]);            
            }
            else if(res[0] ==  "5"){    
                alert(res[1]);
                location.reload();
            }
          
         
         console.log(response);
            });

        });
    }

/* Job Post*/
    /***********/
    if ($('#job_cat').length > 0) {
      // Categories Hide 
      $('#second_level').hide();
      $('#third_level').hide();
      $('#forth_level').hide();


      if ($('#is_update').val() != "") {
          var level = $('#is_level').val();
          if (level >= 2) {
              $('#second_level').show();
          }
          if (level >= 3) {
              $('#third_level').show();
          }
          if (level >= 4) {
              $('#forth_level').show();
          }
      }

      /* Level 1 */
      $('#job_cat').on('change', function () {
          $('.cp-loader').show();
          $.post(ajaxurl, {
              action: 'get_cats',
              cat_id: $("#job_cat").val(),
          }).done(function (response) {
              $('.cp-loader').hide();
              $("#second_level").val('');
              if ($.trim(response) != "") {
                  second_level
                  $('#job_cat_id').val($("#job_cat").val());
                  $('#second_level').show();
                  $('#job_cat_second').html(response);
              } else {
                  $('#second_level').hide();
                  $('#third_level').hide();
                  $('#forth_level').hide();
              }
              // if (get_strings.is_cat_temp == '1') {
              //     /*For Category Templates*/
              //     getCustomTemplate(ajaxurl, $("#job_cat").val(), $("#is_update").val(), true);
              //     /*For Category Templates*/
              // }
          });
      });

      /* Level 2 */
      $('#job_cat_second').on('change', function () {
          $('.cp-loader').show();
          $.post(ajaxurl, {
              action: 'get_cats',
              cat_id: $("#job_cat_second").val(),
          }).done(function (response) {
              $('.cp-loader').hide();
              if ($.trim(response) != "") {
                  $('#ad_cat_id').val($("#ad_cat_sub").val());
                  $('#third_level').show();
                  $('#job_cat_third').html(response);
              } else {
                  $('#third_level').hide();
                  $('#forth_level').hide();
              }
              // if (get_strings.is_cat_temp == '1') {
              //     /*For Category Templates*/
              //     getCustomTemplate(ajaxurl, $("#job_cat").val(), $("#is_update").val(), true);
              //     /*For Category Templates*/
              // }
          });
      });

      /* Level 3 */
      $('#job_cat_third').on('change', function () {
          $('.cp-loader').show();
          $.post(ajaxurl, {
              action: 'get_cats',
              cat_id: $("#job_cat_third").val(),
          }).done(function (response) {
              $('.cp-loader').hide();
              $("#ad_cat_sub_sub_sub").val('');
              if ($.trim(response) != "") {
                  $('#ad_cat_id').val($("#ad_cat_sub_sub").val());
                  $('#forth_level').show();
                  $('#job_cat_forth').html(response);
              } else {
                  $('#forth_level').hide();
              }
              // if (get_strings.is_cat_temp == '1') {
              //     /*For Category Templates*/
              //     getCustomTemplate(ajaxurl, $("#job_cat").val(), $("#is_update").val(), true);
              //     /*For Category Templates*/
              // }
          });
      });

      /* Level 4 */
      $('#ad_cat_sub_sub_sub').on('change', function () {
          $('#ad_cat_id').val($("#ad_cat_sub_sub_sub").val());
      });

  }



  
  // Function to save selected options
function saveSelectedOptions() {
  var pageUrl = window.location.href;
  localStorage.setItem(pageUrl + '_job_cat', $('#job_cat').val());
  localStorage.setItem(pageUrl + '_job_cat_second', $('#job_cat_second').val());
  localStorage.setItem(pageUrl + '_job_cat_third', $('#job_cat_third').val());
  localStorage.setItem(pageUrl + '_job_cat_forth', $('#job_cat_forth').val());
}

// Function to load selected options from local storage
function loadSelectedOptions() {
  var pageUrl = window.location.href;
  var job_cat = localStorage.getItem(pageUrl + '_job_cat');
  var job_cat_second = localStorage.getItem(pageUrl + '_job_cat_second');
  var job_cat_third = localStorage.getItem(pageUrl + '_job_cat_third');
  var job_cat_forth = localStorage.getItem(pageUrl + '_job_cat_forth');

  if (job_cat) {
      $('#job_cat').val(job_cat);
      loadSubCategories(job_cat, job_cat_second, job_cat_third, job_cat_forth);
  }
}

// Function to load sub-categories based on the selected main category
function loadSubCategories(job_cat, job_cat_second, job_cat_third, job_cat_forth) {
  // Load sub-categories for the main category
  $.post(ajaxurl, {
      action: 'get_cats',
      cat_id: job_cat,
  }).done(function(response) {
      if ($.trim(response) != "") {
          $('#second_level').show();
          $('#job_cat_second').html(response);
          if (job_cat_second) {
              $('#job_cat_second').val(job_cat_second);
              loadSubSubCategories(job_cat_second, job_cat_third, job_cat_forth);
          }
      }
  });
}

// Function to load sub-sub-categories based on the selected sub-category
function loadSubSubCategories(job_cat_second, job_cat_third, job_cat_forth) {
  // Load sub-sub-categories for the selected sub-category
  $.post(ajaxurl, {
      action: 'get_cats',
      cat_id: job_cat_second,
  }).done(function(response) {
      if ($.trim(response) != "") {
          $('#third_level').show();
          $('#job_cat_third').html(response);
          if (job_cat_third) {
              $('#job_cat_third').val(job_cat_third);
              loadSubSubSubCategories(job_cat_third, job_cat_forth);
          }
      }
  });
}

// Function to load sub-sub-sub-categories based on the selected sub-sub-category
function loadSubSubSubCategories(job_cat_third, job_cat_forth) {
  // Load sub-sub-sub-categories for the selected sub-sub-category
  $.post(ajaxurl, {
      action: 'get_cats',
      cat_id: job_cat_third,
  }).done(function(response) {
      if ($.trim(response) != "") {
          $('#forth_level').show();
          $('#job_cat_forth').html(response);
          if (job_cat_forth) {
              $('#job_cat_forth').val(job_cat_forth);
          }
      }
  });
}

// Document ready function
$(document).ready(function() {
  if ($('#job_cat').length) {
      loadSelectedOptions();
  }

  $('#job_cat').change(function() {
      saveSelectedOptions();
      var job_cat = $(this).val();
      loadSubCategories(job_cat);
  });

  $('#job_cat_second').change(function() {
      saveSelectedOptions();
      var job_cat_second = $(this).val();
      var job_cat_third = $('#job_cat_third').val();
      var job_cat_forth = $('#job_cat_forth').val();
      loadSubSubCategories(job_cat_second, job_cat_third, job_cat_forth);
  });

  $('#job_cat_third').change(function() {
      saveSelectedOptions();
      var job_cat_third = $(this).val();
      var job_cat_forth = $('#job_cat_forth').val();
      loadSubSubSubCategories(job_cat_third, job_cat_forth);
  });
});

// Function to load sub-categories based on the selected main category
function loadSubCategories(job_cat, job_cat_second, job_cat_third, job_cat_forth) {
  // Clear child categories when parent category changes
  $('#job_cat_second').html('<option value="0">Select Option</option>');
  $('#job_cat_third').html('<option value="0">Select Option</option>');
  $('#job_cat_forth').html('<option value="0">Select Option</option>');

  // Load sub-categories for the main category
  $.post(ajaxurl, {
      action: 'get_cats',
      cat_id: job_cat,
  }).done(function(response) {
      if ($.trim(response) != "") {
          $('#second_level').show();
          $('#job_cat_second').html(response);
          if (job_cat_second) {
              $('#job_cat_second').val(job_cat_second);
              loadSubSubCategories(job_cat_second, job_cat_third, job_cat_forth);
          }
      }
  });
}





    $('#pdfForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
  
        // Get the input value
        const price = $('#price-invoice').val();
      const description=$('#description-invoice').val();
        // Get the values of job_id and candidate_id hidden fields
     //   const jobId = $('#job_id').val();


     const submitButton = $('#generate_pdf');

     // Store the original button text
     
     
     // Change the button text to indicate loading
     submitButton.val('Generating PDF....');
     
    
   
      //  const candidateId = $('#candidate_id').val();
       
     
        // Make an AJAX request
        $.ajax({
          type: 'POST',
          url:ajaxurl,
          data: {
            action: 'store_price',
            price: price,
            rowid:rowid,
            employer_id:employerid,
            description:description,
            job_id: jobid, // Include job_id in the data
            candidate_id: candidateid // Include candidate_id in the data
          },
          success: function(response) {
      
            window.location.href = response;

          },
          error: function(xhr, textStatus, errorThrown) {
            // Handle errors if the AJAX request fails
            console.error(xhr.statusText);
          },
        
        });
      });
  
})(jQuery);