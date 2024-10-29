(function ($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  // $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
  //   $("body").toggleClass("sidebar-toggled");
  //   $(".sidebar").toggleClass("toggled");
  //   if ($(".sidebar").hasClass("toggled")) {
  //     $('.sidebar .collapse').collapse('hide');
  //   };
  // });

  // Function to toggle sidebar state and update localStorage
  function toggleSidebar() {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");

    // Store the sidebar state in localStorage
    const isSidebarToggled = $(".sidebar").hasClass("toggled");
    localStorage.setItem("sidebarToggled", isSidebarToggled.toString());

    if (isSidebarToggled) {
      $('.sidebar .collapse').collapse('hide');
    }
  }

  // Check localStorage on page load
  $(document).ready(function () {
    const storedSidebarState = localStorage.getItem("sidebarToggled");
    if (storedSidebarState === "true") {
      // If the sidebar was toggled, apply the necessary classes
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
    }
  });

  // Toggle sidebar when clicking the button
  $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
    toggleSidebar();
  });



  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function () {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };

    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function () {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function (e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

})(jQuery); // End of use strict



// backto-top btn script
var btn = jQuery('#backto-top');
jQuery(window).scroll(function () {
  if (jQuery(window).scrollTop() > 100) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function (e) {
  e.preventDefault();
  jQuery('html, body').animate({ scrollTop: 0 }, '1000');
});
// backto-top btn script end

// Display error messages on the page
// document.addEventListener('DOMContentLoaded', function () {

//   var errorMessages = document.querySelectorAll('.text-danger');
//   var errorMessagesContainer = document.getElementById('error-messages');
//   if (errorMessagesContainer) {
//     errorMessagesContainer.innerHTML = ''; // Clear previous messages
//     for (var j = 0; j < errorMessages.length; j++) {
//       var errorMessage = document.createElement('div');
//       errorMessage.classList.add('alert', 'alert-danger');
//       errorMessage.textContent = errorMessages[j].innerText;
//       errorMessagesContainer.appendChild(errorMessage);
//     }
//   }
// });
// Display error messages on the page

// Display error messages on the page using sweetalert
document.addEventListener('DOMContentLoaded', function () {
  var errorMessages = document.querySelectorAll('.text-danger');
  async function displayErrors() {
    for (var j = 0; j < errorMessages.length; j++) {
      var errorMessageText = errorMessages[j].innerText;
      await Swal.fire({
        icon: 'error',
        title: errorMessageText,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        customClass: {
          title: 'SwalToastBoxtitle',
          icon: 'SwalToastBoxIcon',
          popup: 'SwalToastBoxhtml'
        },
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
    }
  }
  // Trigger the displayErrors function
  displayErrors();
});


