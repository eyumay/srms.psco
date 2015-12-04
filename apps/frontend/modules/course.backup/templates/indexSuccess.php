<table>
  <thead>
    <tr>

    </tr>
  </thead>
  <tbody>

    <tr>
    <?php foreach($departments as $department ): ?>
        <?php echo $department->getDepartment(); ?>
    <?php endforeach; ?>
    </tr>
  </tbody>
</table>
