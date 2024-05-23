 <!-- Salir del sistema Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Cierre de sesión</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">¿Estas seguro de cerrar sesión?</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                 <a class="btn btn-primary" href="<?= Base_URL(); ?>/Logout">Salir</a>
             </div>
         </div>
     </div>
 </div>

 <!-- Bootstrap core JavaScript-->
 <script src="<?= media(); ?>/js/jquery/jquery.min.js"></script>
 <script src="<?= media(); ?>/js/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- Core plugin JavaScript-->
 <script src="<?= media(); ?>/js/jquery-easing/jquery.easing.min.js"></script>

 <script src="<?= media(); ?>/js/plugins/sweetalert2.all.min.js"></script>

 <!--API Datatable-->
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

 <!--Api DataTable para los botones de expotacion-->
 <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
 <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
 <!-- Custom scripts for all pages-->
 <script src="<?= media(); ?>/js/sb-admin-2.min.js"></script>

 <script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>
 <script>
     var Base_URL = "<?php echo Base_URL; ?>";
 </script>
 </body>

 </html>