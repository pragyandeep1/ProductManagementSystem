 </div>
 <!-- End of Main Content -->

 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy;
                 <script>
                     document.write(new Date().getFullYear())
                 </script> Sailorcom
             </span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->


 <!-- Scroll to Top Button-->
 <div id="backto-top"><i class="fa-solid fa-arrow-up"></i></div>

 <!-- Logout Modal-->
 {{-- <div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-body">
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 <h5 class="modal-title">Ready to Leave?</h5>
                 <p>Select "Logout" below if you are ready to end your current session.</p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                 <a class="btn btn-primary" href="login.php">Logout</a>
             </div>
         </div>
     </div>
 </div> --}}


 <!-- Bootstrap core JavaScript-->
 <script src="{{ asset('js/jquery.min.js') }}"></script>
 <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('js/sb-admin-2.js') }}"></script>
 <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
 <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
 <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('js/select2.min.js') }}"></script>
 <script src="{{ asset('js/treeTable.js') }}"></script>
 <script src="{{ asset('js/method.js') }}"></script>
 <script src="https://cdn.ckeditor.com/4.13.0/full/ckeditor.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

 <script src="{{ asset('js/custom.js') }}"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


 <script>
     $(document).ready(function() {
         $('#SuppliesList,#FacilityFilesList, #PositionList, #UserCareerList, #UsersFilesList, #RolesList, #ToolsList, #UsersList,#ProductsList,#BusinessFilesList,#StockList,#InventoryList,#SupplyBomList,#meterReadList')
             .DataTable({
                 responsive: true
             });
     });
 </script>
 <script>
     $(document).ready(function() {
         // Store the active tab when a tab is shown
         $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
             localStorage.setItem('activeTab', $(e.target).attr('href'));
         });

         // Get the active tab from localStorage
         var activeTab = localStorage.getItem('activeTab');

         // If there is an active tab stored, show it
         if (activeTab) {
             $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
         }
         // Clear localStorage when leaving any edit page
         $('a[href*="edit"]').on('click', function() {
             localStorage.removeItem('activeTab');
         });
     });
 </script>
 <script>
     jQuery(".select2-multiple").select2({
         theme: "bootstrap",
         placeholder: "--Select--",
         maximumSelectionSize: 6,
         containerCssClass: ':all:'
     });
 </script>

 @if ($message = Session::get('success'))
     <script>
         jQuery(document).ready(function() {
             const Toast = Swal.mixin({
                 toast: true,
                 position: "top-end",
                 showConfirmButton: false,
                 timer: 3000,
                 timerProgressBar: true,
                 customClass: {
                     title: 'SwalToastBoxtitle', // Add your custom class here
                     icon: 'SwalToastBoxIcon', // Add your custom class here
                     popup: 'SwalToastBoxhtml' // Add your custom class here
                 },
                 didOpen: (toast) => {
                     toast.onmouseenter = Swal.stopTimer;
                     toast.onmouseleave = Swal.resumeTimer;
                 }
             });
             Toast.fire({
                 icon: "success",
                 title: "{{ $message }}"
             });
         });
     </script>
     {{-- <div class="alert alert-success text-center" role="alert">
        {{ $message }}
    </div> --}}
 @elseif ($message = Session::get('error'))
     <script>
         jQuery(document).ready(function() {
             const Toast = Swal.mixin({
                 toast: true,
                 position: "top-end",
                 showConfirmButton: false,
                 timer: 3000,
                 timerProgressBar: true,
                 customClass: {
                     title: 'SwalToastBoxtitle', // Add your custom class here
                     icon: 'SwalToastBoxIcon', // Add your custom class here
                     popup: 'SwalToastBoxhtml' // Add your custom class here
                 },
                 didOpen: (toast) => {
                     toast.onmouseenter = Swal.stopTimer;
                     toast.onmouseleave = Swal.resumeTimer;
                 }
             });
             Toast.fire({
                 icon: "error",
                 title: "{{ $message }}"
             });
         });
     </script>
     {{-- <div class="alert alert-warning text-center" role="alert">
        {{ $message }}
    </div> --}}
 @endif
 </body>

 </html>
