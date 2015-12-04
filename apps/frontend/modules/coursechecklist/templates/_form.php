<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


Warning: Missing argument 1 for CourseChecklistForm::__construct(), called in /home/eyumay/NetBeansProjects/srmsnew.local/lib/vendor/symfony/lib/generator/sfModelGenerator.class.php on line 331 and defined in /home/eyumay/NetBeansProjects/srmsnew.local/lib/form/doctrine/CourseChecklistForm.class.php on line 15

Notice: Undefined variable: courseChecklistObj in /home/eyumay/NetBeansProjects/srmsnew.local/lib/form/doctrine/CourseChecklistForm.class.php on line 20

Notice: Undefined variable: programIdArray in /home/eyumay/NetBeansProjects/srmsnew.local/lib/model/doctrine/ProgramTable.class.php on line 36
<form action="<?php echo url_for('coursechecklist/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          &nbsp;<a href="<?php echo url_for('coursechecklist/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'coursechecklist/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
