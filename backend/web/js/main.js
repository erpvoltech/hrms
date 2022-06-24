$(function () {   
   $('#unitButton').click(function () {
      $('#modalunit').modal('show')
              .find('#UnitContent')
              .load($(this).attr('value'));
   });
   
     $('#deptButton').click(function () {
      $('#modaldept').modal('show')
              .find('#DeptContent')
              .load($(this).attr('value'));
   });
   
     $('#BatchButton').click(function () {
      $('#modalbatch').modal('show')
              .find('#batchContent')
              .load($(this).attr('value'));
   });
   
    $('#TrainingBatchButton').click(function () {   
        $('#TrainingModelBatch')
            .modal('show')
            .find('#TrainingModelBatchContent')
            .load($(this).attr('value'));			 
    });
   
   /*
   $('#TrrnpopupModal').click(function () {   
        $('#update-modal')
            .modal('show')
            .find('#updateModalContent')
            .load($(this).attr('value'));			 
    });
   */
});
