// CALL PRELOADER ON PAGE LOAD
overlayIn();

// HIDE PRELOADER WHEN THE PAGE IS FULLY LOADED
$(window).on('load', function(){
  overlayOut();
});

// OVERLAY IN
function overlayIn(){
  $('.pageLoader').fadeIn();
}

// OVERLAY OUT
function overlayOut(){
  $('.pageLoader').fadeOut();
}

// CHECK FOR DIGITS ONLY
function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

// DECLARE TOAST
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

$(document).ready(function(){
  $(".datepicker").datepicker({ 
    minDate: 0, 
    dateFormat: 'yy-mm-dd' 
  });

  $(".repeat").on('change', function(){
    var val = $(this).find(":selected").val();
    if(val == 'Week'){
      $(".frequency").hide();
      $(".repeatDay").fadeIn();
    }else if(val == 'Month'){
      $(".repeatDay").hide();
      $(".frequency").fadeIn();
    }else{
      $(".repeatDay").fadeOut();
      $(".frequency").fadeOut();
    }
  });

  $(".when").on('change', function(){
    var val = $(this).val();

    if(val == 'date'){
      $(".eafter").hide();
      $(".edate").fadeIn();
    }else{
      $(".edate").hide();
      $(".eafter").fadeIn();
    }
  });

  $.fn.action = function(){
    $(this).on('click', function(e){
      e.preventDefault();
      var form = $(this).closest('form');
      var dataString = form.serialize();
      var type = $(this).data('type');
      var url = '/create';
  
      if(type == 'delete'){
        url = '/delete';
        dataString = {
          id: $(this).data('id')
        }
      }
  
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: 'POST',
        data: dataString,
        dataType: 'JSON',
        beforeSend: function(){
          overlayIn();
        },
        success: function(data){
          overlayOut();
          Toast.fire({icon: data.status, title: data.msg});
  
          if(type == 'delete'){
            $('tbody').html(data.html);
            $('.action').action();
            $('#exampleModal').eventModal();
          }
        }
      });
    });
  }

  $('.action').action();

  $.fn.eventModal = function(){
    $(this).on('show.bs.modal', function (e) {
      var button = $(e.relatedTarget);
      var id = button.data('id');
  
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/event',
        type: 'POST',
        data: 'id='+id,
        dataType: 'JSON',
        beforeSend: function(){
          $(".modal-title").html('');
          $(".event-data").html('Fetching...');
        },
        success: function(data){
          $(".modal-title").html(data.title);
          $(".event-data").html(data.event);
        }
      });
    });
  }
  $('#exampleModal').eventModal();
});