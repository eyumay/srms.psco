<h4> Managing Program for <span style='color: red'> <?php echo $department->getName(); ?> </span>  </h4>

<br /> <br />
<table style='font-size: 12px'>
  <thead>
    <tr>
       
      <th colspan='2'> Programs </th>

    </tr>
  </thead>
  <tbody>
    <?php foreach ($programs as $program): ?>
    <tr>
      <td> &nbsp; &nbsp;</td>
      <td><a href="<?php echo url_for('program/show?id='.$program->getId()) ?>"><?php echo $program->getName() ?> Program </a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('program/new') ?>">New</a>
