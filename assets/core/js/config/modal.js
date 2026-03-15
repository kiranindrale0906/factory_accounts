var modalsize;
$('body').on("click", '[data-toggle="modal"]', function() {
  modalsize = $(this).attr('modal-size');
  //console.log(modalsize)
});
$(".modal").on('show.bs.modal', function () {
  selectpicker_refresh();
  $(this).children(".modal-dialog").addClass('modal-'+modalsize);
});